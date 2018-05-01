<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\Message\IRemoveTranslationRequest;
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
     * @param IRemoveTranslationRequest $request
     *
     * @return \Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponse
     */
    public function execute(IRemoveTranslationRequest $request)
    {

        $catalogue = $this->lookUpCatalogue($request);
        $catalogue->removeTranslation($request);
        $this->gateway->save($catalogue);

        return $this->transformer()->transform($catalogue);
    }


    /**
     * @param IRemoveTranslationRequest $request
     *
     * @return null|\Tidy\Domain\Entities\TranslationCatalogue
     */
    protected function lookUpCatalogue(IRemoveTranslationRequest $request)
    {
        if (!$catalogue = $this->gateway->findCatalogue($request->catalogueId())) {
            throw new NotFound(sprintf('Unable to find catalogue identified by "%d".', $request->catalogueId()));
        }

        return $catalogue;
    }

}