<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Catalogue;

use Tidy\Components\Audit\Change;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Audit\ChangeResponse;
use Tidy\Domain\Responders\Translation\ChangeResponder;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\Tests\Unit\Domain\Entities\TranslationUntranslated;
use Tidy\UseCases\Translation\Catalogue\DTO\RemoveTranslationRequestDTO;
use Tidy\UseCases\Translation\Catalogue\RemoveTranslation;

class RemoveTranslationTest extends MockeryTestCase
{

    public function test_instantiation()
    {
        $useCase = new RemoveTranslation(mock(ITranslationGateway::class));
        assertThat($useCase, is(anInstanceOf(ChangeResponder::class)));
    }

    public function test_remove()
    {
        $gateway = mock(ITranslationGateway::class);
        $useCase = new RemoveTranslation($gateway);
        $request = RemoveTranslationRequestDTO::make();

        $request
            ->withCatalogueId(TranslationCatalogueEnglishToGerman::ID)
            ->withToken(TranslationUntranslated::MSG_ID)
        ;

        $catalogue   = $this->expect_Gateway_findCatalogue($gateway);
        $translation = $this->expect_Catalogue_find($catalogue);

        $this->expect_Gateway_removeTranslation($gateway, $translation);
        $this->expect_Catalogue_removeTranslation($catalogue, $translation);

        $result = $useCase->execute($request);

        assertThat($result, is(anInstanceOf(ChangeResponse::class)));

        $expected = [
            [
                'op'   => Change::OP_REMOVE,
                'path' => 'messages/220418',
            ],
        ];

        $this->assertArraySubset($expected, $result->changes());
    }

    /**
     * @param $gateway
     *
     * @return mixed|\Mockery\MockInterface
     */
    protected function expect_Gateway_findCatalogue($gateway)
    {
        $catalogue = mock(TranslationCatalogue::class);
        $gateway
            ->expects('findCatalogue')
            ->with(TranslationCatalogueEnglishToGerman::ID)
            ->andReturns($catalogue)
        ;

        $catalogue
            ->expects('getCanonical')
            ->andReturn(TranslationCatalogueEnglishToGerman::CANONICAL);

        return $catalogue;
    }

    /**
     * @param $catalogue
     *
     * @return TranslationUntranslated
     */
    protected function expect_Catalogue_find($catalogue): TranslationUntranslated
    {
        $translation = new TranslationUntranslated();
        $catalogue->expects('find')
                  ->with(TranslationUntranslated::MSG_ID)
                  ->andReturns($translation)
        ;

        return $translation;
    }

    /**
     * @param $gateway
     * @param $translation
     */
    protected function expect_Gateway_removeTranslation($gateway, $translation): void
    {
        $gateway->expects('removeTranslation')->with($translation);
    }

    /**
     * @param $catalogue
     * @param $translation
     */
    protected function expect_Catalogue_removeTranslation($catalogue, $translation): void
    {
        $catalogue->expects('remove')->with($translation);
    }


}