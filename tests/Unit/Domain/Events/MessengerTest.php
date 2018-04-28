<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Events;

use Tidy\Domain\Events\Messenger;
use Tidy\Tests\MockeryTestCase;

class MessengerTest extends MockeryTestCase
{

    public function test_instantiation()
    {
        $messenger = new Messenger();
        assertThat($messenger, is(notNullValue()));
    }

    public function test_Subscribe_UnSubscribe()
    {
        $handler1   = new \stdClass();
        $handler2   = new \stdClass();

        $messenger  = new Messenger();
        $messenger->subscribe($handler1, $handler2);
        assertThat(count($messenger), is(equalTo(2)));

        $messenger->subscribe($handler2);
        assertThat(count($messenger), is(equalTo(2)));

        $messenger->unsubscribe($handler2);
        assertThat(count($messenger), is(equalTo(1)));

    }

    public function test_clear()
    {
        $handler1   = new \stdClass();
        $handler2   = new \stdClass();

        $messenger  = new Messenger();
        $messenger->subscribe($handler1, $handler2);

        $messenger->clear();
        assertThat(count($messenger), is(equalTo(0)));
    }

    public function test_broadcast()
    {
        $handler1 = new class {
            public function onTestCaseExecuted(TestCaseExecuted $event) {
                    $event->info = 'I have been executed.';
            }
        };

        $messenger = new Messenger();
        $messenger->subscribe($handler1);
        $event   = $messenger->broadcast(new TestCaseExecuted());

        assertThat($event->info, is(equalTo('I have been executed.')));

    }

}