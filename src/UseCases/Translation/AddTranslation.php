<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Components\Exceptions\Duplicate;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Audit\ChangeResponseTransformer;
use Tidy\Domain\Responders\Audit\IChangeResponseTransformer;
use Tidy\UseCases\Translation\DTO\AddTranslationRequestDTO;
use Tidy\UseCases\Translation\DTO\TranslationResponseTransformer;

class AddTranslation
{
    /**
     * @var ITranslationGateway
     */
    protected $gateway;

    /**
     * @var ChangeResponseTransformer
     */
    private $transformer;

    /**
     * AddTranslation constructor.
     *
     * @param ITranslationGateway        $gateway
     * @param IChangeResponseTransformer $transformer
     */
    public function __construct(ITranslationGateway $gateway, IChangeResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }

    public function swapTransformer(IChangeResponseTransformer $transformer)
    {
        $previous          = $this->transformer;
        $this->transformer = $transformer;

        return $previous;
    }

    public function execute(AddTranslationRequestDTO $request)
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

        $catalogue->addTranslation($translation);

        $this->gateway->save($catalogue);

        $result = ChangeSet::make();
        $result
            ->add(Change::test($request->catalogueId(), 'catalogueId'))
            ->add(Change::add($translation->toArray(), sprintf('%s/%s', $catalogue->path(), $translation->getId())))
        ;

        return $this->transformer()->transform($result);

    }


    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new ChangeResponseTransformer();
        }

        return $this->transformer;
    }

    /**
     * @param AddTranslationRequestDTO $request
     *
     * @return null|\Tidy\Domain\Entities\TranslationCatalogue
     */
    protected function lookUpCatalogue(AddTranslationRequestDTO $request)
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
     * @param AddTranslationRequestDTO $request
     * @param                          $catalogue
     */
    protected function preserveUniqueness(AddTranslationRequestDTO $request, TranslationCatalogue $catalogue)
    {
        if ($match = $catalogue->find($request->token())) {
            throw new Duplicate(
                sprintf('Duplicate token "%s" in catalogue "%s".', $request->token, $catalogue->getName())
            );
        }
    }


}