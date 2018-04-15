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
use Tidy\Entities\User;
use Tidy\Gateways\IProjectGateway;
use Tidy\Gateways\IUserGateway;
use Tidy\Responders\Project\IProjectResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Entities\ProjectImpl;
use Tidy\Tests\Unit\Entities\UserStub1;
use Tidy\Tests\Unit\Entities\UserStub2;
use Tidy\UseCases\Project\CreateProject;
use Tidy\UseCases\Project\DTO\CreateProjectRequestDTO;
use Tidy\UseCases\Project\DTO\ProjectResponseDTO;
use Tidy\UseCases\Project\DTO\ProjectResponseTransformer;
use Tidy\UseCases\User\DTO\UserExcerptDTO;
use Tidy\UseCases\User\DTO\UserExcerptTransformer;

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
     * @var ITextNormaliser|MockInterface
     */
    protected $normaliser;
    /**
     * @var IUserGateway|MockInterface
     */
    protected $userGateway;

    public function test_instantiation()
    {
        $useCase = new CreateProject(
            mock(IProjectGateway::class),
            mock(IProjectResponseTransformer::class),
            mock(ITextNormaliser::class)
        );

        $this->assertInstanceOf(CreateProject::class, $useCase);
    }

    /**
     * @dataProvider provideProjects
     *
     * @param      $name
     * @param      $description
     * @param      $id
     * @param      $canonical
     * @param User $owner
     */
    public function test_create_success($name, $description, $id, $canonical, User $owner)
    {
        $request = CreateProjectRequestDTO::make();
        $request->withName($name)
                ->withDescription($description)
                ->withOwnerId($owner->getId())
        ;

        $this->expectMakeForOwner($owner->getId(), new ProjectImpl($owner));
        $this->expectNameTransformation($name, $canonical);
        $this->expectIdentifyingSave($name, $description, $id, $canonical, $owner);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(ProjectResponseDTO::class, $response);
        $this->assertEquals($name, $response->getName());
        $this->assertEquals($description, $response->getDescription());
        $this->assertEquals($canonical, $response->getCanonical());
        $this->assertEquals($id, $response->getId());
        $this->assertInstanceOf(UserExcerptDTO::class, $response->getOwner());
        $this->assertEquals($owner->getId(), $response->getOwner()->getId());
        $this->assertEquals($owner->getUserName(), $response->getOwner()->getUserName());


    }


    public function provideProjects()
    {
        return [
            ['My fancy project', 'This describes the project.', 9999, 'my-fancy-project', new UserStub1()],
            ['My other project', 'This is another project.', 7777, 'my-other-project', new UserStub2()],
        ];
    }


    protected function setUp()
    {

        $this->useCase    = new CreateProject(
            mock(IProjectGateway::class),
            mock(IProjectResponseTransformer::class),
            mock(ITextNormaliser::class)
        );

        $this->gateway    = mock(IProjectGateway::class);
        $this->normaliser = mock(ITextNormaliser::class);
        $transformer      = new ProjectResponseTransformer(new UserExcerptTransformer());

        $this->useCase->setProjectGateway($this->gateway);
        $this->useCase->setNormaliser($this->normaliser);
        $this->useCase->setResponseTransformer($transformer);

    }

    private function expectMakeForOwner($ownerId, $returnValue)
    {
        $this->gateway->expects('makeForOwner')->with($ownerId)->andReturn($returnValue);
    }

    /**
     * @param $name
     * @param $description
     * @param $id
     */
    private function expectIdentifyingSave($name, $description, $id, $canonical, $owner)
    {
        $matchesAssertion = function (Project $project) use ($name, $description, $canonical, $owner) {
            if (!$project->getName() === $name) {
                return false;
            }
            if (!$project->getDescription() === $description) {
                return false;
            }
            if (!$project->getCanonical() === $canonical) {
                return false;
            }

            if (!$project->getOwner() === $owner) {
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

    /**
     * @param User $owner
     */
    private function expectOwnerLookup(User $owner)
    {
        $this->userGateway->expects('find')->with($owner->getId())->andReturn($owner);
    }


}