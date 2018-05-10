<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Integration\Components;

use Tidy\Components\AccessControl\AccessControlBroker;
use Tidy\Components\AccessControl\IClaimantProvider;
use Tidy\Components\Events\IDispatcher;
use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Integration\Components\Components;
use Tidy\Tests\MockeryTestCase;

class ComponentsTest extends MockeryTestCase {
    public function testInstantiation() {
        $components = new Components();
        $this->assertNotNull($components);
    }

    public function testInjection() {
        $stringUtilFactory = mock(IStringUtilFactory::class);
        $dispatcher        = mock(IDispatcher::class);
        $broker            = mock(AccessControlBroker::class);
        $components        = new Components($stringUtilFactory, $dispatcher, $broker);

        $this->assertSame($stringUtilFactory, $components->stringUtilFactory());
        $this->assertSame($dispatcher, $components->eventDispatcher());
        $this->assertSame($broker, $components->accessControlBroker(mock(IClaimantProvider::class)));

    }

    public function testStringUtilFactory() {
        $components        = new Components();
        $stringUtilFactory = $components->stringUtilFactory();
        $this->assertInstanceOf(IStringUtilFactory::class, $stringUtilFactory);
        $this->assertSame($stringUtilFactory, $components->stringUtilFactory());
    }

    public function testEventDispatcher() {
        $components = new Components();
        $dispatcher = $components->eventDispatcher();
        $this->assertInstanceOf(IDispatcher::class, $dispatcher);
        $this->assertSame($dispatcher, $components->eventDispatcher());
    }

    public function testAccessControlBroker()
    {
        $components = new Components();
        $this->assertInstanceOf(AccessControlBroker::class, $components->accessControlBroker(mock(IClaimantProvider::class)));

    }

}