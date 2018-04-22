<?php
/**
 * GetProjectCollectionTest.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project;

use Mockery\MockInterface;
use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Requestors\CollectionRequest;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\ProjectSilverTongue;
use Tidy\UseCases\Project\DTO\GetProjectCollectionRequestDTO;
use Tidy\UseCases\Project\DTO\ProjectCollectionResponseDTO;
use Tidy\UseCases\Project\DTO\ProjectCollectionResponseTransformer;
use Tidy\UseCases\Project\DTO\ProjectResponseDTO;
use Tidy\UseCases\Project\GetProject;
use Tidy\UseCases\Project\GetProjectCollection;
use Tidy\UseCases\User\DTO\GetUserCollectionRequestDTO;

class GetProjectCollectionTest extends MockeryTestCase
{


    /**
     * @var GetProjectCollection
     */
    protected $useCase;

    /**
     * @var IProjectGateway|MockInterface
     */
    protected $gateway;

    public function test_instantiation() {
        $useCase = new GetProjectCollection(mock(IProjectGateway::class), mock(ProjectCollectionResponseTransformer::class));
        $this->assertInstanceOf(GetProjectCollection::class, $useCase);
    }

    public function test_GetProjectCollection_with_comparison()
    {
        $page     = 2;
        $pageSize = 15;
        $request  = GetProjectCollectionRequestDTO::make($page, $pageSize);
        $this->assertInstanceOf(CollectionRequest::class, $request);

        $request
            ->withName(Comparison::equalTo(ProjectSilverTongue::NAME))
            ->withDescription(Comparison::containing(ProjectSilverTongue::DESCRIPTION))
            ->withCanonical(Comparison::startsWith(ProjectSilverTongue::CANONICAL))
            ->withId(Comparison::greaterOrEqualTo(ProjectSilverTongue::ID))
        ;

        $criteriaCheck = function ($argument) {
            if (count($argument) != 4) {
                return false;
            }

            return count(array_filter($argument, function ($item) { return !($item instanceof Comparison); })) === 0;
        };

        $this->gateway->expects('fetchCollection')
                      ->with($page, $pageSize, argumentThat($criteriaCheck))
                      ->andReturn([new ProjectSilverTongue()])
                      ->byDefault();
        $this->gateway->expects('total')->with($request->getCriteria())->andReturn(2);

        $result = $this->useCase->execute($request);


        $this->assertInstanceOf(ProjectCollectionResponseDTO::class, $result);
        $this->assertCount(1, $result);
        $this->assertContainsOnly(ProjectResponseDTO::class, $result->getItems());
        $this->assertEquals($pageSize, $result->pageSize());
        $this->assertEquals(1, $result->currentPage());
    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->gateway  = mock(IProjectGateway::class);
        $this->useCase = new GetProjectCollection($this->gateway, new ProjectCollectionResponseTransformer());
    }
}