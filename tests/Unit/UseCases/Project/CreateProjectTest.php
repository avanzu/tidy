<?php
/**
 * CreateProjectTest.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project;


use Mockery\MockInterface;
use Tidy\Components\Normalisation\ITextNormaliser;
use Tidy\Entities\Project;
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
    /**
     *  @var ITextNormaliser|MockInterface
     */
    protected $normaliser;

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
     * @param $canonical
     */
    public function test_create_success($name, $description, $id, $canonical)
    {
        $request = CreateProjectRequestDTO::make();
        $request->withName($name)
                ->withDescription($description)
        ;

        $this->expectMake(new ProjectImpl());
        $this->expectNameTransformation($name, $canonical);
        $this->expectIdentifyingSave($name, $description, $id, $canonical);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(ProjectResponseDTO::class, $response);
        $this->assertEquals($name, $response->getName());
        $this->assertEquals($description, $response->getDescription());
        $this->assertEquals($canonical, $response->getCanonical());
        $this->assertEquals($id, $response->getId());

    }

    public function provideProjects()
    {
        return [
            ['My fancy project', 'This describes the project.', 9999, 'my-fancy-project'],
            ['My other project', 'This is another project.', 7777, 'my-other-project'],
        ];
    }


    protected function setUp()
    {
        $this->gateway   = mock(IProjectGateway::class);
        $this->normaliser = mock(ITextNormaliser::class);
        $this->useCase = new CreateProject();
        $this->useCase->setResponseTransformer(new ProjectResponseTransformer());
        $this->useCase->setProjectGateway($this->gateway);
        $this->useCase->setNormaliser($this->normaliser);

    }

    private function expectMake($returnValue)
    {
        $this->gateway->expects('make')->andReturn($returnValue);
    }

    /**
     * @param $name
     * @param $description
     * @param $id
     */
    private function expectIdentifyingSave($name, $description, $id, $canonical)
    {
        $matchesAssertion = function (Project $project) use ($name, $description, $canonical) {
            if (!$project->getName() === $name) {
                return false;
            }
            if (!$project->getDescription() === $description) {
                return false;
            }
            if( ! $project->getCanonical() === $canonical) {
                return false;
            }

            return true;
        };

        $identify = function (Project $project) use ($id) {
            identify($project, $id);

            return $project;
        };
        $this->gateway
            ->expects('save')
            ->with(argumentThat($matchesAssertion))
            ->andReturnUsing($identify)
        ;
    }

    /**
     * @param $name
     * @param $canonical
     */
    private function expectNameTransformation($name, $canonical)
    {
        $this->normaliser->expects('transform')->with($name)->andReturn($canonical);
    }


}