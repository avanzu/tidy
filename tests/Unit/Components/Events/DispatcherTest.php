<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\Tests\Unit\Components\Events;

use Tidy\Components\Events\Dispatcher;
use Tidy\Tests\MockeryTestCase;

class DispatcherTest extends MockeryTestCase
{

    public function test_instantiation()
    {
        $messenger = new Dispatcher();
        assertThat($messenger, is(notNullValue()));
    }

    public function test_Subscribe_UnSubscribe()
    {
        $handler1   = new \stdClass();
        $handler2   = new \stdClass();

        $messenger  = new Dispatcher();
        $eventName  = TestCaseExecuted::handledBy();
        $messenger->addHandler($eventName, $handler1);
        $messenger->addHandler($eventName, $handler2);

        assertThat($messenger->hasHandlersFor($eventName));
        assertThat(count($messenger->handlersFor($eventName)), is(equalTo(2)));

        $messenger->removeHandler($eventName, $handler2);

        assertThat(count($messenger->handlersFor($eventName)), is(equalTo(1)));

    }

    public function test_clear()
    {
        $handler1   = new \stdClass();
        $handler2   = new \stdClass();

        $messenger  = new Dispatcher();
        $messenger->addHandler('onEventA', $handler1);
        $messenger->addHandler('onEventA', $handler2);
        $messenger->addHandler('onEventB', $handler2);

        $messenger->clear('onEventA');
        assertThat($messenger->hasHandlersFor('onEventA'), is(false));
        assertThat($messenger->hasHandlersFor('onEventB'), is(true));
    }

    public function test_broadcast()
    {
        $handler1 = new class {
            public function onTestCaseExecuted(TestCaseExecuted $event) {
                    $event->info = 'I have been executed.';
            }
        };

        $messenger = new Dispatcher();
        $messenger->addHandler(TestCaseExecuted::handledBy(),$handler1);
        $event   = $messenger->broadcast(new TestCaseExecuted());

        assertThat($event->info, is(equalTo('I have been executed.')));

    }

}