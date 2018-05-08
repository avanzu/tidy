<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Integration\UseCases\User;

use Mockery\MockInterface;
use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Domain\BusinessRules\UserRules;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Integration\Components\Components;
use Tidy\Integration\Domain\BusinessRules;
use Tidy\Integration\Domain\Gateways;
use Tidy\Integration\UseCases\User\IUseCaseFactory;
use Tidy\Integration\UseCases\User\UseCaseFactory;
use Tidy\Tests\MockeryTestCase;
use Tidy\UseCases\User\Activate;
use Tidy\UseCases\User\Create;
use Tidy\UseCases\User\DTO\ActivateRequestBuilder;

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
        $factory = new UseCaseFactory($this->gateways, $this->rules, $this->components);
        $this->assertInstanceOf(IUseCaseFactory::class, $factory);
    }

    public function testMakeCreate()
    {
        $this->gateways->expects('users')->andReturn(mock(IUserGateway::class));
        $this->rules->expects('userRules')->andReturn(mock(UserRules::class));
        $this->components->expects('stringUtilFactory')->andReturn(mock(IStringUtilFactory::class));

        $this->assertInstanceOf(Create::class, $this->factory->makeCreate());

    }

    public function testMakeActivate()
    {

        $this->gateways->expects('users')->andReturn(mock(IUserGateway::class));
        $this->rules->expects('userRules')->andReturn(mock(UserRules::class));
        $this->assertInstanceOf(Activate::class, $this->factory->makeActivate());
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->gateways   = mock(Gateways::class);
        $this->rules      = mock(BusinessRules::class);
        $this->components = mock(Components::class);
        $this->factory    = new UseCaseFactory($this->gateways, $this->rules, $this->components);
    }
}