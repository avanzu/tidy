<?php
/**
 * RenameProjectTest.php
 * Tidy
 * Date: 22.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project;

use Mockery\MockInterface;
use Tidy\Domain\Entities\Project;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Responders\Project\IProjectResponse;
use Tidy\Domain\Responders\Project\IProjectResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\ProjectSilverTongue;
use Tidy\UseCases\Project\DTO\ProjectResponseDTO;
use Tidy\UseCases\Project\DTO\ProjectResponseTransformer;
use Tidy\UseCases\Project\DTO\RenameProjectRequestDTO;
use Tidy\UseCases\Project\RenameProject;
use Tidy\UseCases\Project\UseCaseProject;

class RenameProjectTest extends MockeryTestCase
{
    /**
     * @var IProjectGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var RenameProject
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new RenameProject(mock(IProjectGateway::class), mock(IProjectResponseTransformer::class));

        assertThat($useCase, is(notNullValue()));
        assertThat($useCase, is(anInstanceOf(UseCaseProject::class)));
    }

    public function test_rename()
    {
        $request = RenameProjectRequestDTO::make();
        assertThat($request, is(anInstanceOf(RenameProjectRequestDTO::class)));
        $expectedName        = ProjectSilverTongue::NAME.' Renamed';
        $expectedDescription = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $request
            ->withProjectId(ProjectSilverTongue::ID)
            ->renameTo($expectedName)
            ->describeAs($expectedDescription)
        ;

        $this->expectProjectLookUp(ProjectSilverTongue::ID, new ProjectSilverTongue());
        $this->expectSave($expectedName, $expectedDescription);

        $result = $this->useCase->execute($request);

        assertThat($result, is(anInstanceOf(IProjectResponse::class)));
        assertThat($result->getId(), is(equalTo(ProjectSilverTongue::ID)));
    }




    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(IProjectGateway::class);
        $this->useCase = new RenameProject($this->gateway, new ProjectResponseTransformer());
    }

    protected function expectProjectLookUp($projectId, $returnValue)
    {
        $this->gateway
            ->expects('find')
            ->with($projectId)
            ->andReturns($returnValue)
        ;
    }

    /**
     * @param $expectedName
     * @param $expectedDescription
     */
    protected function expectSave($expectedName, $expectedDescription): void
    {
        $this->gateway->expects('save')->with(
            argumentThat(
                function (Project $project) use ($expectedName, $expectedDescription) {
                    assertThat($project->getName(), is(equalTo($expectedName)));
                    assertThat($project->getDescription(), is(equalTo($expectedDescription)));

                    return true;
                }
            )
        )
        ;
    }
}