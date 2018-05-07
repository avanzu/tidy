<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\BusinessRules\TranslationRules;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\Catalogue\IAddTranslationRequest;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponse;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponseTransformer;
use Tidy\UseCases\Translation\Catalogue\Traits\TNestedItemResponder;

class AddTranslation
{

    use TNestedItemResponder;

    /**
     * @var TranslationRules
     */
    private $rules;

    /**
     * CreateCatalogue constructor.
     *
     * @param ITranslationGateway           $gateway
     * @param TranslationRules              $rules
     * @param ICatalogueResponseTransformer $transformer
     */
    public function __construct(
        ITranslationGateway $gateway,
        TranslationRules $rules,
        ICatalogueResponseTransformer $transformer = null
    ) {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
        $this->rules       = $rules;
    }


    /**
     * @param IAddTranslationRequest $request
     *
     * @return ICatalogueResponse
     */
    public function execute(IAddTranslationRequest $request)
    {
        $catalogue = $this->lookUpCatalogue($request);
        $catalogue->appendTranslation($request, $this->rules);
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

}