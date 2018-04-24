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
use Tidy\Domain\Requestors\Translation\IGetCollectionRequest;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\UseCases\Translation\DTO\CollectionResponseDTO;
use Tidy\UseCases\Translation\DTO\CollectionResponseTransformer;
use Tidy\UseCases\Translation\DTO\GetCollectionRequestDTO;
use Tidy\UseCases\Translation\GetCollection;

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
        $request = GetCollectionRequestDTO::make();
        assertThat($request, is(anInstanceOf(IGetCollectionRequest::class)));

        $request
            ->withName(Comparison::equalTo('some name'))
            ->withSourceLanguage(Comparison::equalTo('de'))
            ->withTargetLanguage(Comparison::equalTo('en'))
            ->withSourceCulture(Comparison::isEmpty())
            ->withTargetCulture(Comparison::isNotEmpty())
            ->withId(Comparison::in(1,2,3))
            ->withCanonical(Comparison::notIn('errors', 'validators'))
            ->withProject(Comparison::equalTo('some project'))
            ->withSourceString(Comparison::startsWith('lorem'))
            ->withLocaleString(Comparison::endsWith('ipsum'))
            ->withToken(Comparison::containing('label'))
            ->withState(Comparison::in('new', 'needs-translation'))
            ;

        $this->expectGetCollectionWithBoundaryAndCriteria($request);
        $this->expectTotalWithCriteria($request);

        $result = $this->useCase->execute($request);

        assertThat($result, is(anInstanceOf(CollectionResponseDTO::class)));


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
    protected function expectGetCollectionWithBoundaryAndCriteria($request)
    {
        $this->gateway
            ->expects('getCollection')
            ->with(
                anInstanceOf(Boundary::class),
                argumentThat(
                    function ($criteria) use ($request) {
                        assertThat($criteria, is(equalTo($request->criteria())));

                        return true;
                    }
                )
            )
            ->andReturns([new TranslationCatalogueEnglishToGerman()])
        ;
    }

    /**
     * @param $request
     */
    protected function expectTotalWithCriteria($request)
    {
        $this->gateway->expects('total')->with($request->criteria())->andReturns(1);
    }

}