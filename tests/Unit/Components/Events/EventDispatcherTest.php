<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Components\Events;

use PHPUnit\Framework\TestCase;
use Tidy\Components\Events\EventDispatcher;
use Tidy\Components\Events\IDispatcher;
use Tidy\Components\Events\IEvent;
use Tidy\Components\Events\ISubscriber;
use Tidy\Components\Exceptions\InvalidArgument;
use Tidy\Tests\MockeryTestCase;

class EventDispatcherTest extends MockeryTestCase
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    public function testInstantiation()
    {
        $dispatcher = new EventDispatcher();
        $this->assertInstanceOf(IDispatcher::class, $dispatcher);
    }

    public function testListenTo()
    {
        $this->eventDispatcher->listenTo('something', function (IEvent $event) { });
        $this->assertCount(1, $this->eventDispatcher->listenersFor('something'));
        $this->eventDispatcher->listenTo('something', function (IEvent $event) { }, 1);
        $this->assertCount(2, $this->eventDispatcher->listenersFor('something'));

        $this->eventDispatcher->listenTo('something_else', function () { });
        $this->assertCount(1, $this->eventDispatcher->listenersFor('something_else'));
        $this->assertCount(2, $this->eventDispatcher->listenersFor('something'));
    }

    public function testListenToChecksForCallable()
    {
        try {
            $this->eventDispatcher->listenTo('event_33', 'this_is_no_function');
            $this->fail('Failed to fail.');
        } catch (InvalidArgument $invalidArgument) {
            $this->assertStringMatchesFormat(
                'Failed to add event listener for "%s". Expected callable got "%s".',
                $invalidArgument->getMessage()
            );
        }

    }

    public function testAddSubscriber()
    {
        $subscriber = new class implements ISubscriber
        {

            public function onEvent1() { }

            public function onEvent2() { }

            public function subscribeTo()
            {
                return [
                    'event_1' => ['onEvent1'],
                    'event_2' => ['onEvent2', 1],
                ];
            }
        };

        $this->eventDispatcher->addSubscriber($subscriber);
        $this->assertCount(1, $this->eventDispatcher->listenersFor('event_1'));
        $this->assertCount(1, $this->eventDispatcher->listenersFor('event_2'));

    }

    public function testStopListening()
    {
        $listener1 = function () { };
        $listener2 = function () { };
        $this->eventDispatcher->listenTo('event_99', $listener1);
        $this->eventDispatcher->listenTo('event_99', $listener2);
        $this->eventDispatcher->stopListening('event_99', $listener1);
        $this->assertCount(1, $this->eventDispatcher->listenersFor('event_99'));
        $this->assertSame($listener2, $this->eventDispatcher->listenersFor('event_99')->current());

        $this->eventDispatcher->stopListening('event_99', function(){});
        $this->assertCount(1, $this->eventDispatcher->listenersFor('event_99'));
        $this->assertSame($listener2, $this->eventDispatcher->listenersFor('event_99')->current());
    }

    public function testRemoveSubscriber()
    {
        $subscriber = new class implements ISubscriber
        {

            public function onEvent1() { }

            public function onEvent2() { }

            public function subscribeTo()
            {
                return [
                    'event_1' => ['onEvent1'],
                    'event_2' => ['onEvent2', 1],
                ];
            }
        };

        $this->eventDispatcher->addSubscriber($subscriber);
        $this->assertCount(1, $this->eventDispatcher->listenersFor('event_1'));
        $this->assertCount(1, $this->eventDispatcher->listenersFor('event_2'));

        $this->eventDispatcher->removeSubscriber($subscriber);
        $this->assertCount(0, $this->eventDispatcher->listenersFor('event_1'));
        $this->assertCount(0, $this->eventDispatcher->listenersFor('event_2'));
    }

    public function testBroadcast()
    {
        $event = new TestCaseExecuted();

        $this->eventDispatcher->listenTo(TestCaseExecuted::NAME, function(TestCaseExecuted $event){
            $event->info[] = 'listener1';
        });
        $this->eventDispatcher->listenTo(TestCaseExecuted::NAME, function(TestCaseExecuted $event){
            $event->info[] = 'listener2';
        }, 1);

        $this->eventDispatcher->broadcast($event);

        $this->assertEquals(['listener2', 'listener1'], $event->info);

        $event2 = new TestCaseExecuted();
        $this->eventDispatcher->broadcast($event2);
        $this->assertEquals(['listener2', 'listener1'], $event2->info);

    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->eventDispatcher = new EventDispatcher();
    }
}