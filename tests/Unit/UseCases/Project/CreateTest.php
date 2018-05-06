<?php
/**
 * CreateTest SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project;

use Mockery\MockInterface;
use Tidy\Components\AccessControl\AccessControlBroker;
use Tidy\Components\AccessControl\IClaimable;
use Tidy\Components\Events\Dispatcher;
use Tidy\Components\Normalisation\ITextNormaliser;
use Tidy\Domain\Entities\Project;
use Tidy\Domain\Entities\User;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Responders\AccessControl\IOwnerExcerpt;
use Tidy\Domain\Responders\Project\IResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\ProjectImpl;
use Tidy\Tests\Unit\Fixtures\Entities\UserStub1;
use Tidy\Tests\Unit\Fixtures\Entities\UserStub2;
use Tidy\UseCases\AccessControl\DTO\OwnerExcerptTransformer;
use Tidy\UseCases\Project\Create;
use Tidy\UseCases\Project\DTO\CreateRequestBuilder;
use Tidy\UseCases\Project\DTO\ResponseDTO;
use Tidy\UseCases\Project\DTO\ResponseTransformer;

class CreateTest extends MockeryTestCase
{

    /**
     * @var IProjectGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var Create
     */
    protected $useCase;

    /**
     * @var ITextNormaliser|MockInterface
     */
    protected $normaliser;

    /**
     * @var Dispatcher
     */
    protected $messenger;

    /**
     * @var AccessControlBroker|MockInterface
     */
    protected $broker;


    public function test_instantiation()
    {
        $useCase = new Create(
            mock(IProjectGateway::class),
            mock(AccessControlBroker::class),
            mock(IResponseTransformer::class)
        );

        $this->assertInstanceOf(Create::class, $useCase);

    }

    /**
     * @dataProvider provideProjects
     *
     * @param      $name
     * @param      $description
     * @param      $id
     * @param      $canonical
     * @param User $owner
     * @param      $expectedCanonical
     */
    public function test_create_success($name, $description, $id, $canonical, User $owner, $expectedCanonical)
    {
        if (empty($canonical)) {
            $this->expectNameTransformation($name, $expectedCanonical);
        }

        $request = (new CreateRequestBuilder($this->normaliser))
            ->withName($name)
            ->withDescription($description)
            ->withOwnerId($owner->getId())
            ->withCanonical($canonical)
            ->build()
        ;

        $project = new ProjectImpl();

        $this->expectMake($project);
        $this->expectUniqueCanonicalCheck($expectedCanonical, null);

        $this->broker->expects('lookUp')->with($owner->getId())->andReturn($owner);

        $this->expectIdentifyingSave($name, $description, $id, $canonical, $owner);


        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(ResponseDTO::class, $response);
        $this->assertEquals($name, $response->getName());
        $this->assertEquals($description, $response->getDescription());
        $this->assertEquals($expectedCanonical, $response->getCanonical());
        $this->assertIssUuid($response->getId());
        $this->assertInstanceOf(IOwnerExcerpt::class, $response->getOwner());
        $this->assertEquals($owner->getId(), $response->getOwner()->getIdentity());
        $this->assertEquals($owner->getUserName(), $response->getOwner()->getName());
        $this->assertEquals(sprintf('/%s/%s', Project::PREFIX, $expectedCanonical), $response->path());

    }


    public function provideProjects()
    {
        return [
            'given canonical'       => [
                'name'              => 'My fancy project',
                'description'       => 'This describes the project.',
                'ID'                => 9999,
                'canonical'         => 'my-fancy-project',
                'owner'             => new UserStub1(),
                'expectedCanonical' => 'my-fancy-project',
            ],
            'transformed canonical' => [
                'name'              => 'My other project',
                'description'       => 'This is another project.',
                'ID'                => 7777,
                'canonical'         => '',
                'owner'             => new UserStub2(),
                'expectedCanonical' => 'my-other-project',
            ],
        ];
    }


    protected function setUp()
    {

        $this->useCase = new Create(
            mock(IProjectGateway::class), mock(AccessControlBroker::class), mock(IResponseTransformer::class)
        );

        $this->gateway    = mock(IProjectGateway::class);
        $this->normaliser = mock(ITextNormaliser::class);
        $this->broker     = mock(AccessControlBroker::class);
        $this->messenger  = new Dispatcher();
        $transformer      = new ResponseTransformer(new OwnerExcerptTransformer());

        $this->useCase->setProjectGateway($this->gateway);
        $this->useCase->setResponseTransformer($transformer);
        $this->useCase->setAccessControlBroker($this->broker);


    }

    private function expectMake(IClaimable $returnValue)
    {
        $this->gateway->expects('make')->andReturn($returnValue);
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
        $this->gateway
            ->expects('save')
            ->with(argumentThat($matchesAssertion))
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

    private function expectUniqueCanonicalCheck($expectedCanonical, $returnValue) {
        $this->gateway->expects('findByCanonical')->with($expectedCanonical)->andReturn($returnValue);
    }


}