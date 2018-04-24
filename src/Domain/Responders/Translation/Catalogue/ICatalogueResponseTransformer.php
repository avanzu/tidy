<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Domain\Responders\Translation\Catalogue;

use Tidy\Domain\Entities\TranslationCatalogue;

interface ICatalogueResponseTransformer
{
    /**
     * @param TranslationCatalogue $catalogue
     *
     * @return ICatalogueResponse
     */
    public function transform(TranslationCatalogue $catalogue);
}