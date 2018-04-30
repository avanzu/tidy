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
        $translation = new TranslationImpl();
        $translation->setToken($token)
                    ->setSourceString($sourceString)
                    ->setLocaleString($localeString)
                    ->setMeaning($meaning)
                    ->setNotes($notes)
                    ->setState($state)
        ;

        return $translation;
    }
}