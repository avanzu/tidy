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
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Entities\TranslationDomain;
use Tidy\Domain\Events\Translation\Created;
use Tidy\Domain\Events\Translation\Described;
use Tidy\Domain\Events\Translation\DomainChanged;
use Tidy\Domain\Events\Translation\Removed;
use Tidy\Domain\Events\Translation\SetUp;
use Tidy\Domain\Events\Translation\Translated;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\Catalogue\IAddTranslationRequest;
use Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest;
use Tidy\Domain\Requestors\Translation\Message\IRemoveTranslationRequest;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueEnglishToGerman as Catalogue;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueImpl;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationTranslated;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationUntranslated;
use Tidy\UseCases\Translation\Message\DTO\DescribeRequestBuilder;
use Tidy\UseCases\Translation\Message\DTO\TranslateRequestBuilder;

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
        $request   = $this->makeSetUpRequest(
            $name,
            $canonical,
            $sourceLanguage,
            $sourceCulture,
            $targetLanguage,
            $targetCulture
        );
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
        $request   = $this->makeCreateRequest();
        $gateway   = mock(ITranslationGateway::class);
        $this->expectCatalogueLookUp($gateway, $this->makeDomain(), new Catalogue());

        try {
            $catalogue->setUp($request, new TranslationCatalogues($gateway));
            $this->fail('Failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(PreconditionFailed::class)));
            $this->assertStringMatchesFormat(
                'Invalid domain "%s". Already in use by "%s".',
                current($exception->getErrors())
            );
        }
    }

    public function testSetUp()
    {
        $catalogue = new TranslationCatalogueImpl();
        $request   = $this->makeCreateRequest();

        $gateway = mock(ITranslationGateway::class);
        $this->expectCatalogueLookUp($gateway, $this->makeDomain(), null);

        $catalogue->setUp($request, new TranslationCatalogues($gateway));

        $this->assertCount(1, $catalogue->events());
        $event = $catalogue->events()->dequeue();
        $this->assertInstanceOf(SetUp::class, $event);
        $this->assertEquals($catalogue->getId(), $event->id());
    }

    public function test_addTranslation()
    {
        $catalogue     = new Catalogue();
        $expectedToken = 'message.token.add_translation';
        $request       = $this->makeAddTranslationRequest($expectedToken);

        $catalogue->appendTranslation($request);
        assertThat($catalogue->find($expectedToken), is(anInstanceOf(Translation::class)));

        $this->assertCount(1, $catalogue->events());
        $event = $catalogue->events()->dequeue();
        $this->assertInstanceOf(Created::class, $event);
        $this->assertEquals($catalogue->getId(), $event->id());
        $this->assertEquals($expectedToken, $event->translation()->getToken());
    }

    public function test_addTranslation_verifies_token_presence()
    {
        $catalogue = new Catalogue();
        $request   = mock(IAddTranslationRequest::class);
        $request->allows('token')->andReturn('');
        try {
            $catalogue->appendTranslation($request);
            $this->fail('Failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(PreconditionFailed::class)));
            $this->assertStringMatchesFormat('Token cannot be empty.', $exception->getErrors()->atIndex('token'));
        }
    }

    public function test_addTranslation_verifies_token_uniqueness()
    {
        $catalogue = new Catalogue();
        $request   = mock(IAddTranslationRequest::class);
        $request->allows('token')->andReturn(TranslationTranslated::MSG_ID);
        $request->allows('sourceString')->andReturn('The add translation source string');

        try {
            $catalogue->appendTranslation($request);
            $this->fail('Failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(PreconditionFailed::class)));
            $this->assertStringMatchesFormat(
                'Token %s already exists translated as "%s".',
                $exception->getErrors()->atIndex('token')
            );
        }
    }

    public function testRemoveTranslation()
    {
        $catalogue = new Catalogue();
        $request   = mock(IRemoveTranslationRequest::class);
        $request->shouldReceive('catalogueId')->andReturn(Catalogue::ID);
        $request->shouldReceive('token')->andReturn(TranslationTranslated::MSG_ID);

        $catalogue->removeTranslation($request);

        $this->assertNull($catalogue->find(TranslationTranslated::MSG_ID));
        $this->assertCount(1, $catalogue->events());
        $event = $catalogue->events()->dequeue();
        $this->assertInstanceOf(Removed::class, $event);
        $this->assertEquals($catalogue->getId(), $event->id());
        $this->assertInstanceOf(Translation::class, $event->translation());
        $this->assertEquals(TranslationTranslated::MSG_ID, $event->translation()->getToken());

    }

    public function testDefineSourceLocale()
    {
        $catalogue = new Catalogue();
        $catalogue->defineSourceLocale('pt');

        $this->assertEquals('pt', $catalogue->sourceLocale());
        $event = $catalogue->events()->dequeue();
        $this->assertInstanceOf(DomainChanged::class, $event);

        $this->assertEquals('messages.pt.de-DE', (string)$event->domain());
    }

    public function testDefineTargetLocale()
    {
        $catalogue = new Catalogue();
        $catalogue->defineTargetLocale('en', 'in');

        $this->assertEquals('en-IN', $catalogue->targetLocale());
        $event = $catalogue->events()->dequeue();
        $this->assertInstanceOf(DomainChanged::class, $event);

        $this->assertEquals('messages.en-US.en-IN', (string)$event->domain());
    }

    /**
     * @param $expected
     * @param $state
     * @param $expectedState
     *
     * @dataProvider provideTranslations
     */
    public function test_translate($expected, $state, $expectedState)
    {
        $catalogue = new Catalogue();
        $request   = (new TranslateRequestBuilder())
            ->withCatalogueId(Catalogue::ID)
            ->withToken(TranslationUntranslated::MSG_ID)
            ->translateAs($expected)
            ->commitStateTo($state)
            ->build()
        ;

        $catalogue->translate($request);
        $this->assertEquals($expected, $catalogue->find(TranslationUntranslated::MSG_ID)->getLocaleString());
        $this->assertEquals($expectedState, $catalogue->find(TranslationUntranslated::MSG_ID)->getState());

        $this->assertCount(1, $catalogue->events());
        $event = $catalogue->events()->dequeue();
        $this->assertInstanceOf(Translated::class, $event);
        $this->assertEquals($catalogue->getId(), $event->id());
        $this->assertEquals(TranslationUntranslated::MSG_ID, $event->translation()->getToken());
    }


    public function testDescribe()
    {
        $catalogue = new Catalogue();
        $expected  = 'my new description';
        $request   = (new DescribeRequestBuilder())
            ->withCatalogueId(Catalogue::ID)
            ->withToken(TranslationUntranslated::MSG_ID)
            ->describeAs($expected)
            ->build()
        ;

        $catalogue->describe($request);

        $this->assertEquals($expected, $catalogue->find(TranslationUntranslated::MSG_ID)->getSourceString());
        $this->assertCount(1, $catalogue->events());
        $event = $catalogue->events()->dequeue();
        $this->assertInstanceOf(Described::class, $event);
        $this->assertEquals($catalogue->getId(), $event->id());
        $this->assertEquals(TranslationUntranslated::MSG_ID, $event->translation()->getToken());
    }

    public function provideTranslations()
    {
        return [
            'translation only' => ['translation only', null, 'translated'],
            'state only'       => ['', 'requires-translation', 'requires-translation'],
            'trans & state'    => ['translation and state', 'new', 'new'],
            'same translation' => [TranslationUntranslated::MSG_SOURCE, null, 'new'],
        ];
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
                'no culture'       => ['de', null, 'en', null, 'de', 'en'],
                'with culture'     => ['de', 'DE', 'en', 'US', 'de-DE', 'en-US'],
                'with faulty case' => ['DE', 'at', 'EN', 'gb', 'de-AT', 'en-GB'],
            ];
    }

    /**
     * @return mixed|\Mockery\MockInterface
     */
    private function makeCreateRequest()
    {
        $request = mock(ICreateCatalogueRequest::class);
        $request->allows('name')->andReturn(Catalogue::NAME);
        $request->allows('canonical')->andReturn(Catalogue::CANONICAL);
        $request->allows('sourceLanguage')->andReturn(Catalogue::SOURCE_LANG);
        $request->allows('sourceCulture')->andReturn(Catalogue::SOURCE_CULTURE);
        $request->allows('targetLanguage')->andReturn(Catalogue::TARGET_LANG);
        $request->allows('targetCulture')->andReturn(Catalogue::TARGET_CULTURE);

        return $request;
    }

    /**
     * @return TranslationDomain
     */
    private function makeDomain(): TranslationDomain
    {
        $domain = new TranslationDomain(
            Catalogue::CANONICAL,
            Catalogue::SOURCE_LANG,
            Catalogue::SOURCE_CULTURE,
            Catalogue::TARGET_LANG,
            Catalogue::TARGET_CULTURE
        );

        return $domain;
    }

    /**
     * @param $gateway
     * @param $domain
     * @param $catalogueToFind
     */
    private function expectCatalogueLookUp($gateway, $domain, $catalogueToFind): void
    {
        $gateway->expects('findByDomain')->with(equalTo($domain))->andReturn($catalogueToFind);
    }

    /**
     * @param $expectedToken
     *
     * @return mixed|\Mockery\MockInterface
     */
    private function makeAddTranslationRequest($expectedToken)
    {
        $request = mock(IAddTranslationRequest::class);
        $request->allows('catalogueId')->andReturn(Catalogue::ID);
        $request->allows('token')->andReturn($expectedToken);
        $request->allows('sourceString')->andReturn('The add translation source string');
        $request->allows('localeString')->andReturn('Übersetzung hinzufügen');
        $request->allows('meaning')->andReturn('Give some meaning');
        $request->allows('notes')->andReturn('Give some additional notes');
        $request->allows('state')->andReturn('translated');

        return $request;
    }

    /**
     * @param $name
     * @param $canonical
     * @param $sourceLanguage
     * @param $sourceCulture
     * @param $targetLanguage
     * @param $targetCulture
     *
     * @return mixed|\Mockery\MockInterface
     */
    private function makeSetUpRequest(
        $name,
        $canonical,
        $sourceLanguage,
        $sourceCulture,
        $targetLanguage,
        $targetCulture
    ) {
        $request = mock(ICreateCatalogueRequest::class);
        $request->allows('name')->andReturn($name);
        $request->allows('canonical')->andReturn($canonical);
        $request->allows('sourceLanguage')->andReturn($sourceLanguage);
        $request->allows('sourceCulture')->andReturn($sourceCulture);
        $request->allows('targetLanguage')->andReturn($targetLanguage);
        $request->allows('targetCulture')->andReturn($targetCulture);

        return $request;
    }


}