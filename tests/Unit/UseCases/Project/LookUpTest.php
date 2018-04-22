<?php
/**
 * LookUpTest.phpSilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project;


use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Responders\Project\IResponse;
use Tidy\Domain\Responders\Project\IResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\ProjectSilverTongue;
use Tidy\UseCases\Project\DTO\LookUpRequestDTO;
use Tidy\UseCases\Project\DTO\ResponseTransformer;
use Tidy\UseCases\Project\LookUp;

class LookUpTest extends MockeryTestCase
{

    /**
     * @var IProjectGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var LookUp
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new LookUp(mock(IProjectGateway::class), mock(IResponseTransformer::class));
        $this->assertInstanceOf(LookUp::class, $useCase);
    }

    public function test_GetProject_success()
    {
        $project = new ProjectSilverTongue();
        $request = LookUpRequestDTO::make();
        $request->withProjectId(ProjectSilverTongue::ID);

        $this->expectFindOnGateway(ProjectSilverTongue::ID, $project);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(IResponse::class, $response);
        $this->assertEquals(ProjectSilverTongue::ID, $response->getId());

    }

    public function test_GetProject_Failure()
    {
        $this->expectException(NotFound::class);
        $this->expectFindOnGateway(123, null);

        $this->useCase->execute(LookUpRequestDTO::make()->withProjectId(123));

    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->gateway = mock(IProjectGateway::class);
        $transformer   = new ResponseTransformer();
        $this->useCase = new LookUp($this->gateway, $transformer);
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