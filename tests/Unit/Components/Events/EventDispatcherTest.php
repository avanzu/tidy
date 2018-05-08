<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Components\Events;

use Tidy\Components\Events\EventDispatcher;
use Tidy\Components\Events\IDispatcher;
use Tidy\Components\Events\IEvent;
use Tidy\Components\Events\IEventHandler;
use Tidy\Tests\MockeryTestCase;

class NormalPriorityHandlerImpl implements IEventHandler
{
    const MESSAGE = 'normal priority handled';

    /** @param TestCaseExecuted $event */
    public function handle(IEvent $event)
    {
        $event->info[] = self::MESSAGE;
    }    public function supports(IEvent $event)
    {
        return $event instanceof TestCaseExecuted;
    }



    public function priority()
    {
        return 0;
    }
}

;

class HighPriorityHandlerImpl implements IEventHandler
{
    const MESSAGE = 'high priority handled';

    public function supports(IEvent $event)
    {
        return $event instanceof TestCaseExecuted;
    }

    /** @param TestCaseExecuted $event */
    public function handle(IEvent $event)
    {
        $event->info[] = self::MESSAGE;
    }

    public function priority()
    {
        return 1;
    }
}

class EventDispatcherTest extends MockeryTestCase
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    private $handler;

    public function testInstantiation()
    {
        $dispatcher = new EventDispatcher(new NormalPriorityHandlerImpl(), new HighPriorityHandlerImpl());
        $this->assertInstanceOf(IDispatcher::class, $dispatcher);
        $this->assertInstanceOf(\Countable::class, $dispatcher);

        $this->assertCount(2, $dispatcher);
    }

    public function testAttachDetach()
    {

        $handler = new NormalPriorityHandlerImpl();
        $this->eventDispatcher->attach($handler);
        $this->assertTrue($this->eventDispatcher->contains($handler));

        $this->eventDispatcher->attach($handler);
        $this->assertCount(1, $this->eventDispatcher);

        $this->eventDispatcher->detach($handler);
        $this->assertFalse($this->eventDispatcher->contains($handler));

        $this->eventDispatcher->detach(mock(IEventHandler::class));

    }

    public function testBroadcast()
    {
        $this->eventDispatcher->attach(new NormalPriorityHandlerImpl());
        $event = new TestCaseExecuted();
        $this->eventDispatcher->broadcast($event);

        $this->assertEquals([NormalPriorityHandlerImpl::MESSAGE], $event->info);

        $event = new class implements IEvent
        {
            public $info = false;
        };

        $this->eventDispatcher->broadcast($event);
        $this->assertFalse($event->info);

    }

    public function testBroadcastWithPriority()
    {
        $this->eventDispatcher->attach(new NormalPriorityHandlerImpl());
        $this->eventDispatcher->attach(new HighPriorityHandlerImpl());

        $event = new TestCaseExecuted();
        $this->eventDispatcher->broadcast($event);

        $this->assertEquals([HighPriorityHandlerImpl::MESSAGE, NormalPriorityHandlerImpl::MESSAGE], $event->info);

        $this->eventDispatcher->broadcast(mock(IEvent::class));

    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->eventDispatcher = new EventDispatcher();

    }
}