<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Integration\Domain;

use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Integration\Domain\IGatewayFactory;
use Tidy\Tests\MockeryTestCase;

class GatewaysTest extends MockeryTestCase
{

    public function testInstantiation()
    {
        $manager = new \Tidy\Integration\Domain\Gateways(mock(IGatewayFactory::class));
        $this->assertNotNull($manager);
    }

    public function testMakeUserGateway()
    {
        $factory = $this->expectMakeUserGateway(mock(IGatewayFactory::class));
        $manager = new \Tidy\Integration\Domain\Gateways($factory);
        $result  = $manager->users();
        $this->assertInstanceOf(IUserGateway::class, $result);
        $this->assertSame($result, $manager->users());

    }

    public function testMakeProjectGateway()
    {
        $factory = $this->expectMakeProjectGateway(mock(IGatewayFactory::class));
        $manager = new \Tidy\Integration\Domain\Gateways($factory);
        $result  = $manager->projects();
        $this->assertInstanceOf(IProjectGateway::class, $result);
        $this->assertSame($result, $manager->projects());
    }

    public function testMakeTranslationGateway()
    {
        $factory = $this->expectMakeTranslationGateway(mock(IGatewayFactory::class));
        $manager = new \Tidy\Integration\Domain\Gateways($factory);
        $result  = $manager->translations();
        $this->assertInstanceOf(ITranslationGateway::class, $result);
        $this->assertSame($result, $manager->translations());
    }



    /**
     * @param $factory
     *
     * @return
     */
    private function expectMakeUserGateway($factory)
    {
        $factory->expects('makeUserGateway')->andReturnUsing(function () { return mock(IUserGateway::class); });
        return $factory;
    }

    /**
     * @param $factory
     *
     * @return
     */
    private function expectMakeProjectGateway($factory)
    {
        $factory->expects('makeProjectGateway')->andReturnUsing(function () { return mock(IProjectGateway::class); });
        return $factory;
    }

    /**
     * @param $factory
     *
     * @return
     */
    private function expectMakeTranslationGateway($factory)
    {
        $factory->expects('makeTranslationGateway')->andReturnUsing(
            function () { return mock(ITranslationGateway::class); }
        )
        ;
        return $factory;
    }
}