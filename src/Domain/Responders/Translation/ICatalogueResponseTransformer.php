<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Domain\Responders\Translation;

use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\UseCases\Translation\DTO\CatalogueResponseDTO;

interface ICatalogueResponseTransformer
{
    /**
     * @param TranslationCatalogue $catalogue
     *
     * @return ICatalogueResponse
     */
    public function transform(TranslationCatalogue $catalogue);
}