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
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\Message\ItemResponder;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponse;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\Tests\Unit\Domain\Entities\TranslationUntranslated;
use Tidy\UseCases\Translation\Message\DTO\TranslateRequestDTO;
use Tidy\UseCases\Translation\Message\Translate;

class TranslateTest extends MockeryTestCase
{

    const LIPSUM = 'Proin vitae sapien bibendum odio maximus ornare. Suspendisse pulvinar vel neque consectetur maximus. In in eros libero.';

    /**
     * @var MockInterface|ITranslationGateway
     */
    protected $gateway;

    /**
     * @var \Tidy\UseCases\Translation\Message\Translate
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new Translate(mock(ITranslationGateway::class));
        assertThat($useCase, is(notNullValue()));
        assertThat($useCase, is(anInstanceOf(ItemResponder::class)));
    }


    public function test_execute_success()
    {
        $request = TranslateRequestDTO::make();
        assertThat($request, is(notNullValue()));

        $request
            ->withCatalogueId(TranslationCatalogueEnglishToGerman::ID)
            ->withToken(TranslationUntranslated::MSG_ID)
            ->translateAs(self::LIPSUM)
            ->commitStateTo('translated')
        ;

        $catalogue   = mock(TranslationCatalogueEnglishToGerman::class);
        $translation = new TranslationUntranslated();

        $this->expect_findCatalogue_on_gateway($catalogue);
        $this->expect_find_on_catalogue($catalogue, $translation);
        $this->expect_save_on_gateway($catalogue);

        $response = $this->useCase->execute($request);

        assertThat($response, is(anInstanceOf(ITranslationResponse::class)));
        assertThat($translation->getLocaleString(), is(equalTo(self::LIPSUM)));
        assertThat($translation->getState(), is(equalTo('translated')));
    }


    public function test_execute_with_unknown_catalogue_throws_NotFound()
    {
        $this->gateway->expects('findCatalogue')->andReturns(null);

        try {

            $this->useCase->execute(TranslateRequestDTO::make()->withCatalogueId(1234876543));

            $this->fail('failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(NotFound::class)));
            $this->assertStringMatchesFormat('Unable to find catalogue identified by "%d".', $exception->getMessage());
        }
    }

    public function test_execute_with_unknown_token_throws_NotFound()
    {

        $catalogue = mock(TranslationCatalogue::class);
        $this->gateway->expects('findCatalogue')->andReturns($catalogue);
        $catalogue->expects('find')->with('token.unknown')->andReturns(null);
        $catalogue->expects('getName')->andReturns('Some Catalogue');

        try {

            $this->useCase->execute(
                TranslateRequestDTO::make()->withCatalogueId(1234876543)->withToken('token.unknown')
            );

            $this->fail('failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(NotFound::class)));
            $this->assertStringMatchesFormat(
                'Unable to find translation identified by "%s" in catalogue "%s".',
                $exception->getMessage()
            );
        }

    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new \Tidy\UseCases\Translation\Message\Translate($this->gateway);
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
    protected function expect_find_on_catalogue($catalogue, $translation): void
    {
        $catalogue->expects('find')->with(TranslationUntranslated::MSG_ID)->andReturns($translation);
    }

    /**
     * @param $catalogue
     */
    protected function expect_save_on_gateway($catalogue): void
    {
        $this->gateway->expects('save')->with($catalogue);
    }
}