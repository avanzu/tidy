<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\ITranslationCatalogueResponseTransformer;
use Tidy\Domain\Responders\Translation\ITranslationResponseTransformer;

class CreateCatalogue
{
    /**
     * @var ITranslationGateway
     */
    protected $gateway;

    /**
     * @var ITranslationResponseTransformer
     */
    private $transformer;

    /**
     * CreateCatalogue constructor.
     *
     * @param ITranslationGateway                      $gateway
     * @param ITranslationCatalogueResponseTransformer $transformer
     */
    public function __construct(ITranslationGateway $gateway, ITranslationCatalogueResponseTransformer $transformer)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }


}