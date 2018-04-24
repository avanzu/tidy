<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Entities;

use Tidy\Components\Exceptions\LanguageIsEmpty;
use Tidy\Tests\MockeryTestCase;

class TranslationCatalogueTest extends MockeryTestCase
{

    /**
     * @dataProvider provideLocales
     *
     * @param $sourceLanguage
     * @param $sourceCulture
     * @param $targetLanguage
     * @param $targetCulture
     * @param $expectedSourceLocale
     * @param $expectedTargetLocale
     */
    public function test_locale($sourceLanguage, $sourceCulture, $targetLanguage, $targetCulture, $expectedSourceLocale,
        $expectedTargetLocale
    )
    {
        $catalogue = new TranslationCatalogueImpl();
        $catalogue
            ->setSourceLanguage($sourceLanguage)
            ->setSourceCulture($sourceCulture)
            ->setTargetLanguage($targetLanguage)
            ->setTargetCulture($targetCulture);
        $this->assertEquals($expectedSourceLocale, $catalogue->sourceLocale());
        $this->assertEquals($expectedTargetLocale, $catalogue->targetLocale());
    }

    public function test_sourceLocale_throws_RuntimeException_with_empty_language()
    {
        $catalogue = new TranslationCatalogueImpl();
        $catalogue->setSourceCulture('de');

        try {
            $catalogue->sourceLocale();
            $this->fail('failed to fail.');
        } catch(\Exception $exception) {
            assertThat($exception, is(anInstanceOf(LanguageIsEmpty::class)));
            assertThat($exception->getMessage(), is(equalTo('Source language is not defined.')));
        }
    }

    public function test_targetLocale_throws_RuntimeException_with_empty_language()
    {
        $catalogue = new TranslationCatalogueImpl();
        $catalogue->setTargetCulture('de');

        try {
            $catalogue->targetLocale();
            $this->fail('failed to fail.');
        } catch(\Exception $exception) {
            assertThat($exception, is(anInstanceOf(LanguageIsEmpty::class)));
            assertThat($exception->getMessage(), is(equalTo('Target language is not defined.')));
        }
    }

    public function provideLocales() {
        return
            [
                'no culture' => ['de', null, 'en', null, 'de', 'en'],
                'with culture' => ['de', 'DE', 'en', 'US', 'de-DE', 'en-US'],
                'with unproper case' => ['DE', 'at', 'EN', 'gb', 'de-AT', 'en-GB']
            ];
    }


}