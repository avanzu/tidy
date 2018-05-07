<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 06.05.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Events;

use Tidy\Domain\Events\User\Registered;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TimmyUser;

class UserRegisteredTest extends MockeryTestCase
{
    public function testUserDecomposition()
    {
        $event = new Registered(TimmyUser::ID);
        $this->assertEquals(TimmyUser::ID, $event->id());

    }
}