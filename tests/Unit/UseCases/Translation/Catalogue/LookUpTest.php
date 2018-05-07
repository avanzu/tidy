<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Catalogue;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\UseCases\Translation\Catalogue\DTO\CatalogueResponseDTO;
use Tidy\UseCases\Translation\Catalogue\DTO\LookUpRequestBuilder;
use Tidy\UseCases\Translation\Catalogue\LookUp;

class LookUpTest extends MockeryTestCase
{

    /**
     * @var ITranslationGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var LookUp
     */
    protected $useCase;

    public function test_instantiation()
    {

        $useCase = new LookUp(mock(ITranslationGateway::class));
        assertThat($useCase, is(notNullValue()));

    }

    public function test_execute()
    {
        $request = (new LookUpRequestBuilder())
            ->withId(TranslationCatalogueEnglishToGerman::ID)
            ->build()
        ;

        $this->expectFindCatalogue();

        $result = $this->useCase->execute($request);
        assertThat($result, is(anInstanceOf(CatalogueResponseDTO::class)));
        assertThat($result->getId(), is(equalTo(TranslationCatalogueEnglishToGerman::ID)));
        assertThat($result->count(), is(2));
    }


    public function test_execute_notfound()
    {
        $request = (new LookUpRequestBuilder())->withId(99999)->build();
        $this->gateway->expects('findCatalogue')->andReturn(null);
        try {
            $this->useCase->execute($request);
            $this->fail('Failed to fail...');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(NotFound::class)));
            $this->assertStringMatchesFormat('Unable to find catalogue identified by "%d".', $exception->getMessage());
        }
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new LookUp($this->gateway);
    }

    protected function expectFindCatalogue(): void
    {
        $this->gateway
            ->expects('findCatalogue')
            ->with(TranslationCatalogueEnglishToGerman::ID)
            ->andReturns(new TranslationCatalogueEnglishToGerman())
        ;
    }


}