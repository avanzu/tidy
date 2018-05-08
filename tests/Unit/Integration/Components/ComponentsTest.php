<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Integration\Components;

use Tidy\Components\DataAccess\Comparison;
use Tidy\Components\Events\IDispatcher;
use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Integration\Components\Components;
use Tidy\Tests\MockeryTestCase;

class ComponentsTest extends MockeryTestCase
{
    public function testInstantiation()
    {
        $components = new Components();
        $this->assertNotNull($components);
    }

    public function testStringUtilFactory()
    {
        $components = new Components();
        $stringUtilFactory = $components->stringUtilFactory();
        $this->assertInstanceOf(IStringUtilFactory::class, $stringUtilFactory);
        $this->assertSame($stringUtilFactory, $components->stringUtilFactory());
    }

    public function testEventDispatcher()
    {
        $components = new Components();
        $dispatcher = $components->eventDispatcher();
        $this->assertInstanceOf(IDispatcher::class, $dispatcher);
        $this->assertSame($dispatcher, $components->eventDispatcher());

    }

}