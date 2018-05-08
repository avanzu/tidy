<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Integration\Domain;

use Mockery\MockInterface;
use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Domain\BusinessRules\ProjectRules;
use Tidy\Domain\BusinessRules\TranslationRules;
use Tidy\Domain\BusinessRules\UserRules;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Integration\Components\Components;
use Tidy\Integration\Domain\BusinessRulesFactory;
use Tidy\Integration\Domain\Gateways;
use Tidy\Integration\Domain\IBusinessRulesFactory;
use Tidy\Tests\MockeryTestCase;

class BusinessRulesFactoryTest extends MockeryTestCase
{

    /**
     * @var Components|MockInterface
     */
    private $components;

    /**
     * @var Gateways|MockInterface
     */
    private $gateways;

    public function testInstantiation()
    {
        $factory = new BusinessRulesFactory(mock(Components::class), mock(Gateways::class));
        $this->assertInstanceOf(IBusinessRulesFactory::class, $factory);
    }


    public function testUserRules()
    {
        $this->components->expects('stringUtilFactory')->andReturn(mock(IStringUtilFactory::class));
        $this->gateways->expects('users')->andReturn(mock(IUserGateway::class));

        $factory = new BusinessRulesFactory($this->components, $this->gateways);
        $this->assertInstanceOf(UserRules::class, $factory->makeUserRules());

    }

    public function testProjectRules()
    {
        $this->gateways->expects('projects')->andReturn(mock(IProjectGateway::class));
        $factory = new BusinessRulesFactory($this->components, $this->gateways);
        $this->assertInstanceOf(ProjectRules::class, $factory->makeProjectRules());
    }

    public function testTranslationRules()
    {
        $this->gateways->expects('translations')->andReturn(mock(ITranslationGateway::class));
        $factory = new BusinessRulesFactory($this->components, $this->gateways);
        $this->assertInstanceOf(TranslationRules::class, $factory->makeTranslationRules());

    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->components = mock(Components::class);
        $this->gateways   = mock(Gateways::class);
    }
}