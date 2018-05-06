<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Message;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\Message\ITranslateRequest;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponse;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationUntranslated;
use Tidy\UseCases\Translation\Message\DTO\TranslateRequestBuilder;
use Tidy\UseCases\Translation\Message\Translate;

class TranslateTest extends MockeryTestCase
{

    const LIPSUM = 'Proin vitae sapien bibendum odio maximus ornare. Suspendisse pulvinar vel neque consectetur maximus. In in eros libero.';

    /**
     * @var MockInterface|ITranslationGateway
     */
    protected $gateway;

    /**
     * @var Translate
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new Translate(mock(ITranslationGateway::class));
        assertThat($useCase, is(notNullValue()));
    }


    public function test_execute_success()
    {
        $request = (new TranslateRequestBuilder())
            ->withCatalogueId(TranslationCatalogueEnglishToGerman::ID)
            ->withToken(TranslationUntranslated::MSG_ID)
            ->translateAs(self::LIPSUM)
            ->commitStateTo('translated')
            ->build()
        ;

        $catalogue = mock(TranslationCatalogueEnglishToGerman::class);
        $translation = new TranslationUntranslated();

        $this->expect_findCatalogue_on_gateway($catalogue);
        $this->expect_translate_on_catalogue($catalogue, $translation);
        $this->expect_save_on_gateway($catalogue);

        $response = $this->useCase->execute($request);

        assertThat($response, is(anInstanceOf(ITranslationResponse::class)));
        assertThat($response->getLocaleString(), is(equalTo(self::LIPSUM)));
        assertThat($response->getState(), is(equalTo('translated')));
    }


    public function test_execute_with_unknown_catalogue_throws_NotFound()
    {
        $this->gateway->expects('findCatalogue')->andReturns(null);

        try {

            $this->useCase->execute(
                (new TranslateRequestBuilder())->withCatalogueId(1234876543)->build()
            );

            $this->fail('failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(NotFound::class)));
            $this->assertStringMatchesFormat('Unable to find catalogue identified by "%d".', $exception->getMessage());
        }
    }

    public function test_execute_with_unknown_token_throws_NotFound()
    {

        $catalogue = new TranslationCatalogueEnglishToGerman();
        $this->gateway->expects('findCatalogue')->andReturns($catalogue);

        try {

            $this->useCase->execute(
                (new TranslateRequestBuilder())
                    ->withCatalogueId(TranslationCatalogueEnglishToGerman::ID)
                    ->withToken('token.unknown')
                    ->build()
            );

            $this->fail('failed to fail.');
        } catch (PreconditionFailed $exception) {
            $this->assertStringMatchesFormat(
                'Unable to find translation identified by "%s" in catalogue "%s".',
                $exception->atIndex('token')
            );
        }

    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new Translate($this->gateway);
    }

    /**
     * @param $catalogue
     */
    protected function expect_findCatalogue_on_gateway($catalogue): void
    {
        $this->gateway
            ->expects('findCatalogue')
            ->with(TranslationCatalogueEnglishToGerman::ID)
            ->andReturns($catalogue)
        ;
    }

    /**
     * @param $catalogue
     * @param $translation
     */
    protected function expect_translate_on_catalogue($catalogue, $translation): void
    {
        $catalogue->expects('translate')
                  ->with(anInstanceOf(ITranslateRequest::class))
                  ->andReturnUsing(
                      function (ITranslateRequest $request) {
                          return new TranslationUntranslated(
                              TranslationUntranslated::MSG_SOURCE,
                              $request->localeString(),
                              $request->state()
                          );
                      }
                  )
        ;
    }

    /**
     * @param $catalogue
     */
    protected function expect_save_on_gateway($catalogue): void
    {
        $this->gateway->expects('save')->with($catalogue);
    }
}