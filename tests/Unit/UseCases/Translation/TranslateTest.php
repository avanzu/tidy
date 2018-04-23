<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation;

use Mockery\MockInterface;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\Tests\Unit\Domain\Entities\TranslationUntranslated;
use Tidy\UseCases\Translation\DTO\ChangeResponseDTO;
use Tidy\UseCases\Translation\DTO\TranslateRequestDTO;
use Tidy\UseCases\Translation\Translate;

class TranslateTest extends MockeryTestCase
{

    /**
     * @var MockInterface|ITranslationGateway
     */
    protected $gateway;

    /**
     * @var Translate
     */
    protected $useCase;

    const LIPSUM = 'Proin vitae sapien bibendum odio maximus ornare. Suspendisse pulvinar vel neque consectetur maximus. In in eros libero.';

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

        $response = $this->useCase->execute($request);

        assertThat($response, is(anInstanceOf(ChangeResponseDTO::class)));

    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new Translate($this->gateway);
    }
}