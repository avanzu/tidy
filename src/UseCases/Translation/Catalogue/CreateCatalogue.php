<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue;

use Tidy\Domain\BusinessRules\TranslationRules;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponseTransformer;
use Tidy\UseCases\Translation\Catalogue\Traits\TItemResponder;

class CreateCatalogue
{
    use TItemResponder;

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


    public function execute(ICreateCatalogueRequest $request)
    {

        $catalogue = $this->gateway->makeCatalogueForProject($request->projectId());
        $catalogue->setUp($request, $this->rules);
        $this->gateway->save($catalogue);

        return $this->transformer()->transform($catalogue);
    }


}