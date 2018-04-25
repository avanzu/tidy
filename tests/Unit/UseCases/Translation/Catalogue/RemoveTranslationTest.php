<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Catalogue;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponse;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman as Catalogue;
use Tidy\Tests\Unit\Domain\Entities\TranslationUntranslated;
use Tidy\UseCases\Translation\Catalogue\DTO\RemoveTranslationRequestBuilder;
use Tidy\UseCases\Translation\Catalogue\RemoveTranslation;

class RemoveTranslationTest extends MockeryTestCase
{

    /**
     * @var ITranslationGateway
     */
    private $gateway;

    /**
     * @var RemoveTranslation
     *
     */
    private $useCase;

    public function test_instantiation()
    {
        $useCase = new RemoveTranslation(mock(ITranslationGateway::class));
        assertThat($useCase, is(notNullValue()));
    }

    public function test_remove()
    {

        $request = (new RemoveTranslationRequestBuilder)
            ->withCatalogueId(Catalogue::ID)
            ->withToken(TranslationUntranslated::MSG_ID)
            ->build()
        ;;

        $this->expect_Gateway_findCatalogue(new Catalogue(), Catalogue::ID);
        $this->expect_Gateway_removeTranslation(TranslationUntranslated::ID);

        $result = $this->useCase->execute($request);

        assertThat($result, is(anInstanceOf(ICatalogueResponse::class)));

        assertThat(count($result), is(1));

    }

    public function test_remove_with_unknown_Catalogue_throws_NotFound()
    {

        $catalogueId = 100009999;
        $this->expect_Gateway_findCatalogue(null, $catalogueId);

        try {
            $this->useCase->execute((new RemoveTranslationRequestBuilder())->withCatalogueId($catalogueId)->build());
            $this->fail('Failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(NotFound::class)));
            $this->assertStringMatchesFormat('Unable to find catalogue identified by "%d".', $exception->getMessage());
        }
    }

    public function test_remove_with_unknown_token_throws_NotFound()
    {

        $catalogueId = 100009999;
        $catalogue   = $this->expect_Gateway_findCatalogue(mock(TranslationCatalogue::class), $catalogueId);

        $this->expect_Catalogue_find($catalogue, 'some_token', null);
        $this->expect_Catalogue_getName($catalogue, 'The Catalogue');

        try {
            $this->useCase->execute(
                (new RemoveTranslationRequestBuilder())
                    ->withCatalogueId($catalogueId)
                    ->withToken('some_token')
                    ->build()
            );

            $this->fail('Failed to fail.');
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
        $this->useCase = new RemoveTranslation($this->gateway);
    }

    /**
     * @param $catalogue
     *
     * @param $catalogueId
     *
     * @return mixed|\Mockery\MockInterface
     */
    protected function expect_Gateway_findCatalogue($catalogue, $catalogueId)
    {
        $this
            ->gateway
            ->expects('findCatalogue')
            ->with($catalogueId)
            ->andReturns($catalogue)
        ;

        return $catalogue;
    }

    /**
     * @param $catalogue
     *
     * @param $token
     *
     * @param $translation
     *
     * @return TranslationUntranslated
     */
    protected function expect_Catalogue_find($catalogue, $token, $translation)
    {
        $catalogue->expects('find')
                  ->with($token)
                  ->andReturns($translation)
        ;

        return $translation;
    }

    /**
     * @param $translation
     */
    protected function expect_Gateway_removeTranslation($translationId): void
    {
        $this->gateway->expects('removeTranslation')->with(
            argumentThat(
                function (Translation $translation) use ($translationId) {
                    assertThat($translation->getId(), is(equalTo($translationId)));

                    return true;
                }
            )
        )
        ;
    }

    /**
     * @param $catalogue
     * @param $translation
     */
    protected function expect_Catalogue_removeTranslation($catalogue, $translation): void
    {
        $catalogue->expects('remove')->with($translation);
    }

    /**
     * @param $catalogue
     * @param $canonical
     */
    protected function expect_Catalogue_getCanonical($catalogue, $canonical): void
    {
        $catalogue
            ->expects('getCanonical')
            ->andReturn($canonical)
        ;
    }

    /**
     * @param $catalogue
     * @param $name
     */
    protected function expect_Catalogue_getName($catalogue, $name): void
    {
        $catalogue->expects('getName')->andreturns($name);
    }


}