<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 10.05.18
 *
 */

namespace Tidy\Tests\Unit\Integration\Domain;

use Tidy\Components\AccessControl\AccessControlBroker;
use Tidy\Components\DependencyInjection\Container;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Integration\Components\Components;
use Tidy\Integration\Domain\AccessControl;
use Tidy\Integration\Domain\Gateways;
use Tidy\Tests\MockeryTestCase;

class AccessControlTest extends MockeryTestCase
{

    public function testInstantiation()
    {
        $acl = new AccessControl(mock(Components::class), mock(Gateways::class));
        $this->assertInstanceOf(Container::class, $acl);
    }

    public function testBroker()
    {
        $components = mock(Components::class);
        $gateways   = mock(Gateways::class);
        $components->expects('accessControlBroker')->andReturn(mock(AccessControlBroker::class));
        $gateways->expects('users')->andReturn(mock(IUserGateway::class));

        $acl    = new AccessControl($components, $gateways);
        $broker = $acl->broker();
        $this->assertInstanceOf(AccessControlBroker::class, $broker);
    }
}