<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation;

use Mockery\MockInterface;
use Tidy\Components\Audit\Change;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\Tests\Unit\Domain\Entities\TranslationUntranslated;
use Tidy\Domain\Responders\Audit\ChangeResponse;
use Tidy\UseCases\Translation\DTO\TranslateRequestDTO;
use Tidy\UseCases\Translation\Translate;

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
        $request = TranslateRequestDTO::make();
        assertThat($request, is(notNullValue()));

        $request
            ->withCatalogueId(TranslationCatalogueEnglishToGerman::ID)
            ->withToken(TranslationUntranslated::MSG_ID)
            ->translateAs(self::LIPSUM)
            ->commitStateTo('translated')
        ;

        $path = (new TranslationCatalogueEnglishToGerman())->path();

        $catalogue   = mock(TranslationCatalogueEnglishToGerman::class);
        $translation = new TranslationUntranslated();

        $this->gateway
            ->expects('findCatalogue')
            ->with(TranslationCatalogueEnglishToGerman::ID)
            ->andReturns($catalogue)
        ;

        $catalogue->expects('path')->andReturn($path);
        $catalogue->expects('find')->with(TranslationUntranslated::MSG_ID)->andReturns($translation);

        $this->gateway->expects('save')->with($catalogue);

        $response = $this->useCase->execute($request);

        $expected = [
            [
                'op'    => Change::OP_REPLACE,
                'value' => self::LIPSUM,
                'path'  => sprintf('%s/%s/localeString', $path, TranslationUntranslated::MSG_ID),
            ],
            [
                'op'    => Change::OP_REPLACE,
                'path'  => sprintf('%s/%s/state', $path, TranslationUntranslated::MSG_ID),
                'value' => 'translated',
            ],

        ];

        assertThat($response, is(anInstanceOf(ChangeResponse::class)));
        assertThat($response->changes(), is(arrayContaining($expected)));
        assertThat($translation->getLocaleString(), is(equalTo(self::LIPSUM)));
        assertThat($translation->getState(), is(equalTo('translated')));
    }

    public function test_no_changes()
    {
        $request = TranslateRequestDTO::make();
        assertThat($request, is(notNullValue()));

        $request
            ->withCatalogueId(TranslationCatalogueEnglishToGerman::ID)
            ->withToken(TranslationUntranslated::MSG_ID)
        ;

        $this->gateway->expects('findCatalogue')->andReturns(new TranslationCatalogueEnglishToGerman());
        $this->gateway->shouldReceive('save')->never();

        $result = $this->useCase->execute($request);
        assertThat(count($result->changes()), is(equalTo(0)));

    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new Translate($this->gateway);
    }
}