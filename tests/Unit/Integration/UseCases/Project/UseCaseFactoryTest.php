<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Integration\UseCases\Project;

use Mockery\MockInterface;
use test\Mockery\MockingMethodsWithIterableTypeHintsTest;
use Tidy\Components\AccessControl\AccessControlBroker;
use Tidy\Components\AccessControl\IClaimantProvider;
use Tidy\Domain\BusinessRules\ProjectRules;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Integration\Components\Components;
use Tidy\Integration\Domain\BusinessRules;
use Tidy\Integration\Domain\Gateways;
use Tidy\Integration\UseCases\Project\IUseCaseFactory;
use Tidy\Integration\UseCases\Project\UseCaseFactory;
use Tidy\Tests\MockeryTestCase;
use Tidy\UseCases\Project\Create;

class UseCaseFactoryTest extends MockeryTestCase
{


    /**
     * @var UseCaseFactory
     */
    protected $factory;

    /**
     * @var Gateways|MockInterface
     */
    private $gateways;

    /**
     * @var BusinessRules|MockInterface
     */
    private $rules;

    /**
     * @var Components|MockInterface
     */
    private $components;

    public function testInstantiation()
    {
        $factory = new UseCaseFactory(mock(Gateways::class), mock(BusinessRules::class), mock(Components::class));
        $this->assertInstanceOf(IUseCaseFactory::class, $factory);
    }

    public function testMakeCreate()
    {
        $this->expectGatewayCall();
        $this->expectRulesCall();
        $this->gateways->expects('users')->andReturn(mock(IClaimantProvider::class));
        $this->components->expects('accessControlBroker')->andReturn(mock(AccessControlBroker::class));
        $this->assertInstanceOf(Create::class,$this->factory->makeCreate());
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateways   = mock(Gateways::class);
        $this->rules      = mock(BusinessRules::class);
        $this->components = mock(Components::class);
        $this->factory    = new UseCaseFactory($this->gateways, $this->rules, $this->components);
    }

    private function expectRulesCall(): void
    {
        $this->rules->expects('projectRules')->andReturn(mock(ProjectRules::class));
    }

    private function expectGatewayCall(): void
    {
        $this->gateways->expects('projects')->andReturn(mock(IProjectGateway::class));
    }
}