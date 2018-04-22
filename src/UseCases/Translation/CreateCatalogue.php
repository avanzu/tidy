<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\ICatalogueResponseTransformer;
use Tidy\UseCases\Translation\DTO\CatalogueResponseTransformer;
use Tidy\UseCases\Translation\DTO\CreateCatalogueRequestDTO;

class CreateCatalogue
{
    /**
     * @var ITranslationGateway
     */
    protected $gateway;

    /**
     * @var ICatalogueResponseTransformer
     */
    private $transformer;

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
     * @return ICatalogueResponseTransformer
     */
    protected function transformer()
    {
        if( ! $this->transformer ) $this->transformer = new CatalogueResponseTransformer();
        return $this->transformer;
    }
    public function execute(CreateCatalogueRequestDTO $request)
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