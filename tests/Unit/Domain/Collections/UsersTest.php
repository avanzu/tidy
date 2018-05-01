<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Collections;

use Tidy\Domain\Collections\Users;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TimmyUser;

class UsersTest extends MockeryTestCase
{

    public function test_instantiation()
    {
        $users = new Users(mock(IUserGateway::class));
        assertThat($users, is(notNullValue()));
    }

    public function test_findByUserName()
    {
        $mock  = mock(IUserGateway::class);
        $mock->expects('findByUserName')->with(TimmyUser::USERNAME)->andReturn(new TimmyUser());
        $users = new Users($mock);

        $users->findByUserName(TimmyUser::USERNAME);
    }
}