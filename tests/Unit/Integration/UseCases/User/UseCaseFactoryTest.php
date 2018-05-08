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
use Tidy\UseCases\User\GetCollection;
use Tidy\UseCases\User\LookUp;
use Tidy\UseCases\User\Recover;
use Tidy\UseCases\User\ResetPassword;

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
        $this->expectGatewayCall();
        $this->expectRulesCall();
        $this->expectStringUtilCall();

        $this->assertInstanceOf(Create::class, $this->factory->makeCreate());

    }

    public function testMakeActivate()
    {
        $this->expectGatewayCall();
        $this->expectRulesCall();
        $this->assertInstanceOf(Activate::class, $this->factory->makeActivate());
    }

    public function testMakeRecover()
    {
        $this->expectGatewayCall();
        $this->expectRulesCall();
        $this->assertInstanceOf(Recover::class, $this->factory->makeRecover());
    }

    public function testMakeResetPassword()
    {
        $this->expectGatewayCall();
        $this->expectRulesCall();
        $this->expectStringUtilCall();

        $this->assertInstanceOf(ResetPassword::class, $this->factory->makeResetPassword());
    }

    public function testMakeLookUp()
    {
        $this->expectGatewayCall();
        $this->assertInstanceOf(LookUp::class, $this->factory->makeLookUp());
    }

    public function makeGetCollection()
    {
        $this->expectGatewayCall();
        $this->assertInstanceOf(GetCollection::class, $this->factory->makeGetCollection());
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->gateways   = mock(Gateways::class);
        $this->rules      = mock(BusinessRules::class);
        $this->components = mock(Components::class);
        $this->factory    = new UseCaseFactory($this->gateways, $this->rules, $this->components);
    }

    private function expectGatewayCall(): void
    {
        $this->gateways->expects('users')->andReturn(mock(IUserGateway::class));
    }

    private function expectRulesCall(): void
    {
        $this->rules->expects('userRules')->andReturn(mock(UserRules::class));
    }

    private function expectStringUtilCall(): void
    {
        $this->components->expects('stringUtilFactory')->andReturn(mock(IStringUtilFactory::class));
    }
}