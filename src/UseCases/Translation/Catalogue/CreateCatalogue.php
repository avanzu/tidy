<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue;

use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponseTransformer;
use Tidy\UseCases\Translation\Catalogue\Traits\TItemResponder;

class CreateCatalogue
{
    use TItemResponder;

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


    public function execute(ICreateCatalogueRequest $request)
    {

        $catalogue = $this->gateway->makeCatalogueForProject($request->projectId());
        $catalogue
            ->setName($request->name())
            ->setCanonical($request->canonical())
            ->setSourceLanguage($request->sourceLanguage())
            ->setSourceCulture($request->sourceCulture())
            ->setTargetLanguage($request->targetLanguage())
            ->setTargetCulture($request->targetCulture())
        ;

        $this->gateway->save($catalogue);

        return $this->transformer()->transform($catalogue);
    }


}