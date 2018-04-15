<?php
/**
 * GetProjectTest.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project;


use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Responders\Project\IProjectResponse;
use Tidy\Domain\Responders\Project\IProjectResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\ProjectSilverTongue;
use Tidy\UseCases\Project\DTO\GetProjectRequestDTO;
use Tidy\UseCases\Project\DTO\ProjectResponseTransformer;
use Tidy\UseCases\Project\GetProject;

class GetProjectTest extends MockeryTestCase
{

    /**
     * @var IProjectGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var GetProject
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new GetProject(mock(IProjectGateway::class), mock(IProjectResponseTransformer::class));
        $this->assertInstanceOf(GetProject::class, $useCase);
    }

    public function test_GetProject_success()
    {
        $project = new ProjectSilverTongue();
        $request = GetProjectRequestDTO::make();
        $request->withProjectId(ProjectSilverTongue::ID);

        $this->expectFindOnGateway(ProjectSilverTongue::ID, $project);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(IProjectResponse::class, $response);
        $this->assertEquals(ProjectSilverTongue::ID, $response->getId());

    }

    public function test_GetProject_Failure()
    {
        $this->expectException(NotFound::class);
        $this->expectFindOnGateway(123, null);

        $this->useCase->execute(GetProjectRequestDTO::make()->withProjectId(123));

    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->gateway = mock(IProjectGateway::class);
        $transformer   = new ProjectResponseTransformer();
        $this->useCase = new GetProject($this->gateway, $transformer);
    }

    /**
     * @param $projectId
     * @param $project
     */
    private function expectFindOnGateway($projectId, $project)
    {
        $this->gateway->expects('find')->with($projectId)->andReturn($project);
    }


}