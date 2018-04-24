<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\Components\Exceptions\NotFound;
use Tidy\UseCases\Translation\DTO\GetCatalogueRequestDTO;
use Tidy\UseCases\Translation\DTO\NestedCatalogueResponseTransformer;

class GetCatalogue extends UseCase
{

    public function execute(GetCatalogueRequestDTO $request)
    {
        $catalogue = $this->gateway->findCatalogue($request->id());

        if (!$catalogue) {
            throw new NotFound(sprintf('Unable to find catalogue identified by "%d".', $request->id()));
        }

        return $this->transformer()->transform($catalogue);
    }

    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new NestedCatalogueResponseTransformer();
        }

        return $this->transformer;
    }


}