<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\Traits;

use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponseTransformer;
use Tidy\UseCases\Translation\Catalogue\DTO\NestedCatalogueResponseTransformer;

trait TNestedItemResponder
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
     * @return ICatalogueResponseTransformer
     */
    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new NestedCatalogueResponseTransformer();
        }

        return $this->transformer;
    }
}