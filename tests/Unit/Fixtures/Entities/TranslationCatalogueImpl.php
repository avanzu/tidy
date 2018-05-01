<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\Fixtures\Entities;

use Tidy\Domain\Entities\TranslationCatalogue;

class TranslationCatalogueImpl extends TranslationCatalogue
{

    protected function makeTranslation($token, $sourceString, $localeString, $meaning, $notes, $state)
    {
        return new TranslationImpl($token, $sourceString, $localeString, $meaning, $notes, $state);

    }
}