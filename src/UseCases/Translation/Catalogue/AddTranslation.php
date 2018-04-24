<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue;

use Tidy\Components\Exceptions\Duplicate;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\Catalogue\IAddTranslationRequest;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponseTransformer;
use Tidy\Domain\Responders\Translation\Catalogue\ItemResponder;
use Tidy\UseCases\Translation\Catalogue\Traits\TNestedItemResponder;

class AddTranslation
{

    use TNestedItemResponder;

    /**
     * CreateCatalogue constructor.
     *
     * @param ITranslationGateway           $gateway
     * @param ICatalogueResponseTransformer $transformer
     */
    public function __construct(ITranslationGateway $gateway, ICatalogueResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }


    public function execute(IAddTranslationRequest $request)
    {
        $catalogue = $this->lookUpCatalogue($request);

        $this->preserveUniqueness($request, $catalogue);

        $translation = $this->gateway->makeTranslation();

        $translation
            ->setSourceString($request->sourceString())
            ->setLocaleString($request->localeString())
            ->setMeaning($request->meaning())
            ->setNotes($request->notes())
            ->setState($request->state())
            ->setToken($request->token())
        ;

        $catalogue->add($translation);

        $this->gateway->save($catalogue);

        return $this->transformer()->transform($catalogue);

    }

    public function swapTransformer(ICatalogueResponseTransformer $transformer)
    {
        $previous          = $this->transformer;
        $this->transformer = $transformer;

        return $previous;

    }

    /**
     * @param \Tidy\Domain\Requestors\Translation\Catalogue\IAddTranslationRequest $request
     *
     * @return null|\Tidy\Domain\Entities\TranslationCatalogue
     */
    protected function lookUpCatalogue(IAddTranslationRequest $request)
    {
        $catalogue = $this->gateway->findCatalogue($request->catalogueId());
        if (!$catalogue) {
            throw new NotFound(
                sprintf('Unable to find catalogue identified by "%d".', $request->catalogueId())
            );
        }

        return $catalogue;
    }

    /**
     * @param \Tidy\Domain\Requestors\Translation\Catalogue\IAddTranslationRequest $request
     * @param                                                                      $catalogue
     */
    protected function preserveUniqueness(IAddTranslationRequest $request, TranslationCatalogue $catalogue)
    {
        if ($match = $catalogue->find($request->token())) {
            throw new Duplicate(
                sprintf('Duplicate token "%s" in catalogue "%s".', $request->token, $catalogue->getName())
            );
        }
    }

}