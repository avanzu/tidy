<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Message;

use Mockery\MockInterface;
use Tidy\Components\Collection\Boundary;
use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\ICollectionRequest;
use Tidy\Domain\Responders\Translation\Message\ICollectionResponse;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponse;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\Tests\Unit\Domain\Entities\TranslationTranslated;
use Tidy\Tests\Unit\Domain\Entities\TranslationUntranslated;
use Tidy\UseCases\Translation\Message\DTO\GetCollectionRequestBuilder;
use Tidy\UseCases\Translation\Message\DTO\GetCollectionRequestDTO;
use Tidy\UseCases\Translation\Message\DTO\CollectionResponseTransformer;
use Tidy\UseCases\Translation\Message\GetCollection;

class GetCollectionTest extends MockeryTestCase
{

    /**
     * @var ITranslationGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var GetCollection
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new GetCollection(mock(ITranslationGateway::class), mock(CollectionResponseTransformer::class));
        assertThat($useCase, is(notNullValue()));

    }


    public function test_execute()
    {
        $request = (new GetCollectionRequestBuilder(TranslationCatalogueEnglishToGerman::ID))
            ->withId(Comparison::in(1, 2, 3, 4))
            ->withToken(Comparison::startsWith('label.'))
            ->withSourceString(Comparison::endsWith('world!'))
            ->withLocaleString(Comparison::containing('hello'))
            ->withState(Comparison::notIn('translated', 'final'))
            ->withMeaning(Comparison::isNotEmpty())
            ->withNotes(Comparison::isEmpty())
            ->fromPage(3)
            ->withPageSize(15)
            ->build()
        ;

        $this->expectGetSubSet($request);
        $this->expectSubSetTotal($request);

        $result = $this->useCase->execute($request);
        assertThat($result, is(anInstanceOf(ICollectionResponse::class)));
        assertThat(count($result), is(2));
        $this->assertContainsOnlyInstancesOf(ITranslationResponse::class, $result->items());

    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new GetCollection($this->gateway);
    }

    /**
     * @param $request
     */
    protected function expectGetSubSet($request): void
    {
        $this->gateway
            ->expects('getSubSet')
            ->with(
                TranslationCatalogueEnglishToGerman::ID,
                anInstanceOf(Boundary::class),
                $request->criteria()
            )
            ->andReturns([new TranslationTranslated(), new TranslationUntranslated()])
        ;
    }

    /**
     * @param $request
     */
    protected function expectSubSetTotal($request): void
    {
        $this->gateway->expects('subSetTotal')
                      ->with(TranslationCatalogueEnglishToGerman::ID, $request->criteria())
                      ->andReturns(2)
        ;
    }

}