<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Responders\Translation\ICatalogueResponseTransformer;

class CatalogueResponseTransformer implements ICatalogueResponseTransformer
{
    public function transform(TranslationCatalogue $catalogue)
    {
        $response                 = new CatalogueResponseDTO();
        $response->id             = $catalogue->getId();
        $response->canonical      = $catalogue->getCanonical();
        $response->name           = $catalogue->getName();
        $response->sourceLanguage = $catalogue->getSourceLanguage();
        $response->sourceCulture  = $catalogue->getSourceCulture();
        $response->targetLanguage = $catalogue->getTargetLanguage();
        $response->targetCulture  = $catalogue->getTargetCulture();

        return $response;
    }
}