<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\UseCases\Translation\DTO\CreateCatalogueRequestDTO;

class CreateCatalogue extends UseCase
{


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