<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Gateways;

use Mockery\MockInterface;
use Tidy\Components\AccessControl\AccessControlBroker;
use Tidy\Components\Events\IDispatcher;
use Tidy\Components\Normalisation\TextNormaliser;
use Tidy\Domain\BusinessRules\ProjectRules;
use Tidy\Domain\Events\Project\SetUp;
use Tidy\Domain\Gateways\ProjectGateway;
use Tidy\Domain\Repositories\IProjectRepository;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Gateways\ProjectGatewayImpl;
use Tidy\UseCases\Project\DTO\CreateRequestBuilder;

class ProjectGatewayTest extends MockeryTestCase
{
    /**
     * @var IProjectRepository|MockInterface
     */
    private $repository;

    /**
     * @var AccessControlBroker|MockInterface
     */
    private $broker;

    /**
     * @var IDispatcher|MockInterface
     */
    private $dispatcher;

    /**
     * @var ProjectGateway
     */
    private $gateway;

    public function testSave()
    {
        $project = $this->gateway->make();
        $request = (new CreateRequestBuilder(new TextNormaliser()))
            ->withName('test')
            ->withDescription('some description')
            ->build();
        $rules = mock(ProjectRules::class);
        $rules->expects('verifySetUp');

        $project->setUp($request, $rules);

        $this->dispatcher->expects('broadcast')->with(anInstanceOf(SetUp::class));
        $this->gateway->save($project);

        $this->assertCount(0, $project->events());
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->repository = mock(IProjectRepository::class);
        $this->broker     = mock(AccessControlBroker::class);
        $this->dispatcher = mock(IDispatcher::class);
        $this->gateway    = new ProjectGatewayImpl(
            $this->repository,
            $this->broker,
            $this->dispatcher
        );
    }
}