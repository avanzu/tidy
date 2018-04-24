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
use Tidy\UseCases\Translation\Catalogue\DTO\NestedCatalogueResponseTransformer;
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
        $translation = $this->lookUpTranslation($request, $catalogue);

        $this->gateway->removeTranslation($translation);
        $catalogue->remove($translation);

        return $this->transformer()->transform($catalogue);
    }

    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new NestedCatalogueResponseTransformer();
        }

        return $this->transformer;
    }


    /**
     * @param RemoveTranslationRequestDTO $request
     *
     * @return null|\Tidy\Domain\Entities\TranslationCatalogue
     */
    protected function lookUpCatalogue(RemoveTranslationRequestDTO $request)
    {
        $catalogue = $this->gateway->findCatalogue($request->catalogueId());
        if (!$catalogue) {
            throw new NotFound(sprintf('Unable to find catalogue identified by "%d".', $request->catalogueId()));
        }

        return $catalogue;
    }

    /**
     * @param RemoveTranslationRequestDTO $request
     * @param TranslationCatalogue        $catalogue
     *
     * @return mixed
     */
    protected function lookUpTranslation(RemoveTranslationRequestDTO $request, TranslationCatalogue $catalogue)
    {
        $translation = $catalogue->find($request->token());
        if (!$translation) {
            throw new NotFound(
                sprintf(
                    'Unable to find translation identified by "%s" in catalogue "%s".',
                    $request->token(),
                    $catalogue->getName()
                )
            );
        }

        return $translation;
    }

}