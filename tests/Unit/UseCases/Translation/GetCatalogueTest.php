<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\ProjectSilverTongue;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\UseCases\Translation\DTO\CatalogueResponseDTO;
use Tidy\UseCases\Translation\DTO\GetCatalogueRequestDTO;
use Tidy\UseCases\Translation\GetCatalogue;
use Tidy\UseCases\Translation\UseCase;

class GetCatalogueTest extends MockeryTestCase
{

    /**
     * @var ITranslationGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var GetCatalogue
     */
    protected $useCase;

    public function test_instantiation()
    {

        $useCase = new GetCatalogue(mock(ITranslationGateway::class));
        assertThat($useCase, is(anInstanceOf(UseCase::class)));

    }

    public function test_execute()
    {
        $request = GetCatalogueRequestDTO::make();
        assertThat($request, is(notNullValue()));

        $request
            ->withId(TranslationCatalogueEnglishToGerman::ID)
        ;

        $this->gateway
            ->expects('findCatalogue')
            ->with(TranslationCatalogueEnglishToGerman::ID)
            ->andReturns(new TranslationCatalogueEnglishToGerman());

        $result = $this->useCase->execute($request);
        assertThat($result, is(anInstanceOf(CatalogueResponseDTO::class)));
        assertThat($result->getId(),is(equalTo(TranslationCatalogueEnglishToGerman::ID)));
        assertThat($result->count(), is(2));
    }


    public function test_execute_notfound()
    {
        $request = GetCatalogueRequestDTO::make();
        $request->withId(99999);
        $this->gateway->expects('findCatalogue')->andReturns(null);
        try {
            $this->useCase->execute($request);
            $this->fail('Failed to fail...');
        } catch(\Exception $exception){
            assertThat($exception, is(anInstanceOf(NotFound::class)));
            $this->assertStringMatchesFormat('Unable to find catalogue identified by "%d".', $exception->getMessage());
        }
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new GetCatalogue($this->gateway);
    }


}