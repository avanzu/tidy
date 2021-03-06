<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Catalogue;

use Mockery\MockInterface;
use Tidy\Components\Collection\Boundary;
use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\UseCases\Translation\Catalogue\DTO\CollectionResponseDTO;
use Tidy\UseCases\Translation\Catalogue\DTO\CollectionResponseTransformer;
use Tidy\UseCases\Translation\Catalogue\DTO\GetCollectionRequestBuilder;
use Tidy\UseCases\Translation\Catalogue\GetCatalogueCollection;

class GetCatalogueCollectionTest extends MockeryTestCase
{

    /**
     * @var ITranslationGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var GetCatalogueCollection
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new GetCatalogueCollection(
            mock(ITranslationGateway::class),
            mock(CollectionResponseTransformer::class)
        );
        assertThat($useCase, is(notNullValue()));
    }

    public function test_execute()
    {
        $request = (new GetCollectionRequestBuilder())
            ->withName(Comparison::equalTo('some name'))
            ->withSourceLanguage(Comparison::equalTo('de'))
            ->withTargetLanguage(Comparison::equalTo('en'))
            ->withSourceCulture(Comparison::isEmpty())
            ->withTargetCulture(Comparison::isNotEmpty())
            ->withId(Comparison::in(1, 2, 3))
            ->withCanonical(Comparison::notIn('errors', 'validators'))
            ->withProject(Comparison::equalTo('some project'))
            ->withSourceString(Comparison::startsWith('lorem'))
            ->withLocaleString(Comparison::endsWith('ipsum'))
            ->withToken(Comparison::containing('label'))
            ->withState(Comparison::in('new', 'needs-translation'))
            ->build();

        $this->expectGetCollectionWithBoundaryAndCriteria($request);
        $this->expectTotalWithCriteria($request);

        $result = $this->useCase->execute($request);

        assertThat($result, is(anInstanceOf(CollectionResponseDTO::class)));

    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new GetCatalogueCollection($this->gateway);
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