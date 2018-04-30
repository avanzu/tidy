<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Entities;

use Tidy\Components\Exceptions\InvalidArgument;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Domain\Collections\TranslationCatalogues;
use Tidy\Domain\Entities\TranslationDomain;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueImpl;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationUntranslated;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueEnglishToGerman as Catalogue;

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

    /**
     * @dataProvider provideSimpleSetupData
     *
     * @param $name
     * @param $canonical
     * @param $sourceLanguage
     * @param $sourceCulture
     * @param $targetLanguage
     * @param $targetCulture
     * @param $errorCount
     */
    public function test_setUp_verifies(
        $name,
        $canonical,
        $sourceLanguage,
        $sourceCulture,
        $targetLanguage,
        $targetCulture,
        $errorCount
    ) {
        $catalogue = new TranslationCatalogueImpl();
        $request   = mock(ICreateCatalogueRequest::class);
        $request->allows('name')->andReturn($name);
        $request->allows('canonical')->andReturn($canonical);
        $request->allows('sourceLanguage')->andReturn($sourceLanguage);
        $request->allows('sourceCulture')->andReturn($sourceCulture);
        $request->allows('targetLanguage')->andReturn($targetLanguage);
        $request->allows('targetCulture')->andReturn($targetCulture);
        try {
            $catalogue->setUp($request, new TranslationCatalogues(mock(ITranslationGateway::class)));
            $this->fail('Failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(PreconditionFailed::class)));
            assertThat(count($exception->getErrors()), is(equalTo($errorCount)));
        }
    }


    public function test_setup_verifies_uniqueDomain()
    {
        $catalogue = new TranslationCatalogueImpl();
        $request   = mock(ICreateCatalogueRequest::class);
        $request->allows('name')->andReturn(Catalogue::NAME);
        $request->allows('canonical')->andReturn(Catalogue::CANONICAL);
        $request->allows('sourceLanguage')->andReturn(Catalogue::SOURCE_LANG);
        $request->allows('sourceCulture')->andReturn(Catalogue::SOURCE_CULTURE);
        $request->allows('targetLanguage')->andReturn(Catalogue::TARGET_LANG);
        $request->allows('targetCulture')->andReturn(Catalogue::TARGET_CULTURE);

        $domain = new TranslationDomain(
            Catalogue::CANONICAL, Catalogue::SOURCE_LANG, Catalogue::SOURCE_CULTURE, Catalogue::TARGET_LANG, Catalogue::TARGET_CULTURE);
        $gateway = mock(ITranslationGateway::class);
        $gateway->expects('findByDomain')->with(equalTo($domain))->andReturn(new Catalogue());

        try {
            $catalogue->setUp($request, new TranslationCatalogues($gateway));
            $this->fail('Failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(PreconditionFailed::class)));
            $this->assertStringMatchesFormat('Invalid domain "%s". Already in use by "%s".', current($exception->getErrors()));
        }
    }

    public function provideSimpleSetupData()
    {
        return [
            'empty'             => [
                'name'          => '',
                'canonical'     => '',
                'sourceLang'    => '',
                'sourceCulture' => '',
                'targetLang'    => '',
                'targetCulture' => '',
                'errorCount'    => 4,
            ],
            'invalid canonical' => [
                'name'          => 'Test Catalogue 1',
                'canonical'     => 'a',
                'sourceLang'    => 'de',
                'sourceCulture' => '',
                'targetLang'    => 'pt',
                'targetCulture' => '',
                'errorCount'    => 1,
            ],
            'invalid languages' => [
                'name'          => 'Test Catalogue 1',
                'canonical'     => 'catalogue-1',
                'sourceLang'    => 'de-DE',
                'sourceCulture' => '',
                'targetLang'    => 'pt-PT',
                'targetCulture' => '',
                'errorCount'    => 2,
            ],

        ];
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