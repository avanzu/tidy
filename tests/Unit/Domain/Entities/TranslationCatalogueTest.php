<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Entities;

use Tidy\Components\Exceptions\InvalidArgument;
use Tidy\Components\Exceptions\LanguageIsEmpty;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueImpl;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationUntranslated;

class TranslationCatalogueTest extends MockeryTestCase
{

    public function test_translation_handling()
    {
        $catalogue   = new TranslationCatalogueImpl();
        $translation = new TranslationUntranslated();

        $catalogue->add($translation);
        assertThat($catalogue->find($translation->getToken()), is($translation));
        $catalogue->remove($translation);
        assertThat($catalogue->find($translation->getToken()), is(nullValue()));

        $catalogue->remove($translation);
    }

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
    public function test_locale(
        $sourceLanguage,
        $sourceCulture,
        $targetLanguage,
        $targetCulture,
        $expectedSourceLocale,
        $expectedTargetLocale
    ) {
        $catalogue = new TranslationCatalogueImpl();
        $catalogue
            ->defineSourceLocale($sourceLanguage, $sourceCulture)
            ->defineTargetLocale($targetLanguage, $targetCulture)
        ;

        $this->assertEquals($expectedSourceLocale, $catalogue->sourceLocale());
        $this->assertEquals($expectedTargetLocale, $catalogue->targetLocale());
    }

    public function test_sourceLocale_throws_RuntimeException_with_empty_language()
    {
        $catalogue = new TranslationCatalogueImpl();

        try {
            $catalogue->defineSourceLocale('', 'de');
            $this->fail('failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(InvalidArgument::class)));
            $this->assertStringStartsWith('Expected 2 character string, got ', $exception->getMessage());
        }
    }


    public function test_targetLocale_throws_RuntimeException_with_empty_language()
    {
        $catalogue = new TranslationCatalogueImpl();

        try {
            $catalogue->defineTargetLocale('', 'de');
            $this->fail('failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(InvalidArgument::class)));
            $this->assertStringStartsWith('Expected 2 character string, got ', $exception->getMessage());
        }
    }



    public function provideLocales()
    {
        return
            [
                'no culture'         => ['de', null, 'en', null, 'de', 'en'],
                'with culture'       => ['de', 'DE', 'en', 'US', 'de-DE', 'en-US'],
                'with unproper case' => ['DE', 'at', 'EN', 'gb', 'de-AT', 'en-GB'],
            ];
    }



}