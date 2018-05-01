<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponseTransformer;
use Tidy\UseCases\Translation\Catalogue\DTO\RemoveTranslationRequestDTO;
use Tidy\UseCases\Translation\Catalogue\Traits\TNestedItemResponder;

class RemoveTranslation
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


    /**
     * @param RemoveTranslationRequestDTO $request
     *
     * @return \Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponse
     */
    public function execute(RemoveTranslationRequestDTO $request)
    {

        $catalogue   = $this->lookUpCatalogue($request);
        $catalogue->removeTranslation($request);
        $this->gateway->save($catalogue);

        return $this->transformer()->transform($catalogue);
    }


    /**
     * @param RemoveTranslationRequestDTO $request
     *
     * @return null|\Tidy\Domain\Entities\TranslationCatalogue
     */
    protected function lookUpCatalogue(RemoveTranslationRequestDTO $request)
    {
        if (!$catalogue = $this->gateway->findCatalogue($request->catalogueId())) {
            throw new NotFound(sprintf('Unable to find catalogue identified by "%d".', $request->catalogueId()));
        }

        return $catalogue;
    }

}