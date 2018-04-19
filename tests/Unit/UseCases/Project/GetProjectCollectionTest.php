<?php
/**
 * GetProjectCollectionTest.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project;

use Mockery\MockInterface;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Requestors\CollectionRequest;
use Tidy\Tests\MockeryTestCase;
use Tidy\UseCases\Project\DTO\GetProjectCollectionRequestDTO;
use Tidy\UseCases\Project\DTO\ProjectCollectionResponseDTO;
use Tidy\UseCases\Project\DTO\ProjectCollectionResponseTransformer;
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
        $request = GetProjectCollectionRequestDTO::make(1, 10);
        $this->assertNotSame(CollectionRequest::class, $request);

        $result = $this->useCase->execute($request);

        $this->assertInstanceOf(ProjectCollectionResponseDTO::class, $result);
    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->gateway  = mock(IProjectGateway::class);
        $this->useCase = new GetProjectCollection($this->gateway, new ProjectCollectionResponseTransformer());
    }
}