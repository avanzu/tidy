<?php
/**
 * CreateProjectTest.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project;


use Mockery\MockInterface;
use Tidy\Entities\Project;
use Tidy\Entities\User;
use Tidy\Gateways\IProjectGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Entities\ProjectImpl;
use Tidy\UseCases\Project\CreateProject;
use Tidy\UseCases\Project\DTO\CreateProjectRequestDTO;
use Tidy\UseCases\Project\DTO\ProjectResponseDTO;
use Tidy\UseCases\Project\DTO\ProjectResponseTransformer;

class CreateProjectTest extends MockeryTestCase
{

    /**
     * @var IProjectGateway|MockInterface
     */
    protected $gateway;
    /**
     * @var CreateProject
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new CreateProject();
        $this->assertInstanceOf(CreateProject::class, $useCase);
    }

    /**
     * @dataProvider provideProjects
     *
     * @param $name
     * @param $description
     * @param $id
     */
    public function test_create_success($name, $description, $id)
    {
        $request = CreateProjectRequestDTO::make();
        $request->withName($name)
                ->withDescription($description)
        ;


        $this->gateway->expects('make')->andReturn(new ProjectImpl());
        $this->gateway->expects('save')->with(argumentThat(function(Project $project) use($name, $description) {
            if( ! $project->getName() === $name ) return false;
            if( ! $project->getDescription() === $description) return false;
            return true;
        }))->andReturnUsing(function(Project $project) use ($id){
            identify($project, $id);
            return $project;
        });


        $response = $this->useCase->execute($request);
        $this->assertInstanceOf(ProjectResponseDTO::class, $response);
        $this->assertEquals($name, $response->getName());
        $this->assertEquals($description, $response->getDescription());
        $this->assertEquals($id, $response->getId());

    }

    public function provideProjects() {
        return [
            [ 'My fancy project', 'This describes the project.', 9999 ],
            [ 'My other project', 'This is another project.', 7777 ]
        ];
    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->gateway  = mock(IProjectGateway::class);
        $this->useCase  = new CreateProject();
        $this->useCase->setResponseTransformer(new ProjectResponseTransformer());
        $this->useCase->setProjectGateway($this->gateway);

    }




}