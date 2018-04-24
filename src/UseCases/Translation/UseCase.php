<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\ICatalogueResponseTransformer;
use Tidy\UseCases\Translation\DTO\CatalogueResponseTransformer;

abstract class UseCase
{
    /**
     * @var ICatalogueResponseTransformer
     */
    protected $transformer;

    /**
     * @var ITranslationGateway
     */
    protected $gateway;

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
        if (!$this->transformer) {
            $this->transformer = new CatalogueResponseTransformer();
        }

        return $this->transformer;
    }
}