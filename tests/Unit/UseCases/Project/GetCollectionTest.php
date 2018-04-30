<?php
/**
 * GetCatalogueCollectionTest.phpy
 * Date: 19.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project;

use Mockery\MockInterface;
use Tidy\Components\Collection\Boundary;
use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\ProjectSilverTongue;
use Tidy\UseCases\Project\DTO\CollectionResponseDTO;
use Tidy\UseCases\Project\DTO\CollectionResponseTransformer;
use Tidy\UseCases\Project\DTO\GetCollectionRequestBuilder;
use Tidy\UseCases\Project\DTO\GetCollectionRequestDTO;
use Tidy\UseCases\Project\DTO\ResponseDTO;
use Tidy\UseCases\Project\GetCollection;

class GetCollectionTest extends MockeryTestCase
{


    /**
     * @var GetCollection
     */
    protected $useCase;

    /**
     * @var IProjectGateway|MockInterface
     */
    protected $gateway;

    public function test_instantiation()
    {
        $useCase = new GetCollection(mock(IProjectGateway::class), mock(CollectionResponseTransformer::class));
        $this->assertInstanceOf(GetCollection::class, $useCase);
    }

    public function test_GetProjectCollection_with_comparison()
    {
        $page     = 2;
        $pageSize = 15;
        $request  = (new GetCollectionRequestBuilder())
            ->withPageSize($pageSize)
            ->fromPage($page)
            ->withName(Comparison::equalTo(ProjectSilverTongue::NAME))
            ->withDescription(Comparison::containing(ProjectSilverTongue::DESCRIPTION))
            ->withCanonical(Comparison::startsWith(ProjectSilverTongue::CANONICAL))
            ->withId(Comparison::greaterOrEqualTo(ProjectSilverTongue::ID))
            ->withOwner(Comparison::in(1, 2, 3))
            ->build()
        ;

        $this->expectGatewayFetchCollection(new Boundary($page, $pageSize));
        $this->expectGatewayTotal($request);

        $result = $this->useCase->execute($request);

        $this->assertInstanceOf(CollectionResponseDTO::class, $result);
        $this->assertCount(1, $result);
        $this->assertContainsOnly(ResponseDTO::class, $result->getItems());
        $this->assertEquals($pageSize, $result->pageSize());
        $this->assertEquals(1, $result->currentPage());
    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->gateway = mock(IProjectGateway::class);
        $this->useCase = new GetCollection($this->gateway);
    }

    /**
     * @param $page
     * @param $pageSize
     */
    protected function expectGatewayFetchCollection($boundary)
    {
        $criteriaCheck = function ($argument) {
            if (count($argument) != 5) {
                return false;
            }

            return count(array_filter($argument, function ($item) { return !($item instanceof Comparison); })) === 0;
        };

        $this->gateway->expects('fetchCollection')
                      ->with(equalTo($boundary), argumentThat($criteriaCheck))
                      ->andReturn([new ProjectSilverTongue()])
                      ->byDefault()
        ;
    }

    /**
     * @param $request
     */
    protected function expectGatewayTotal($request): void
    {
        $this->gateway->expects('total')->with($request->criteria())->andReturn(2);
    }
}