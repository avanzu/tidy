<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation;

use Mockery\MockInterface;
use Tidy\Components\Collection\Boundary;
use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\CollectionRequest;
use Tidy\Domain\Requestors\ICollectionRequest;
use Tidy\Domain\Requestors\Translation\IGetSubSetRequest;
use Tidy\Domain\Responders\CollectionResponse;
use Tidy\Domain\Responders\Translation\ISubSetResponse;
use Tidy\Domain\Responders\Translation\ITranslationResponse;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\Tests\Unit\Domain\Entities\TranslationTranslated;
use Tidy\Tests\Unit\Domain\Entities\TranslationUntranslated;
use Tidy\UseCases\Translation\DTO\GetSubSetRequestDTO;
use Tidy\UseCases\Translation\DTO\SubSetResponseDTO;
use Tidy\UseCases\Translation\DTO\SubSetResponseTransformer;
use Tidy\UseCases\Translation\DTO\TranslationResponseDTO;
use Tidy\UseCases\Translation\GetTranslationSubSet;

class GetTranslationSubSetTest extends MockeryTestCase
{

    /**
     * @var ITranslationGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var GetTranslationSubSet
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new GetTranslationSubSet(mock(ITranslationGateway::class), mock(SubSetResponseTransformer::class));
        assertThat($useCase, is(notNullValue()));

    }


    public function test_execute()
    {
        $request = GetSubSetRequestDTO::make(TranslationCatalogueEnglishToGerman::ID);
        assertThat($request, is(anInstanceOf(IGetSubSetRequest::class)));
        assertThat($request, is(anInstanceOf(ICollectionRequest::class)));

        assertThat($request->catalogueId(), is(equalTo(TranslationCatalogueEnglishToGerman::ID)));

        $request
            ->withId(Comparison::in(1, 2, 3, 4))
            ->withToken(Comparison::startsWith('label.'))
            ->withSourceString(Comparison::endsWith('world!'))
            ->withLocaleString(Comparison::containing('hello'))
            ->withState(Comparison::notIn('translated', 'final'))
            ->withMeaning(Comparison::isNotEmpty())
            ->withNotes(Comparison::isEmpty())
            ->fromPage(3)
            ->withPageSize(15)
        ;

        $this->expectGetSubSet($request);
        $this->expectSubSetTotal($request);

        $result = $this->useCase->execute($request);
        assertThat($result, is(anInstanceOf(ISubSetResponse::class)));
        assertThat(count($result), is(2));
        $this->assertContainsOnlyInstancesOf(ITranslationResponse::class, $result->items());

    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new GetTranslationSubSet($this->gateway);
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