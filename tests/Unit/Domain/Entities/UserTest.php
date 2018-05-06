<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 06.05.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Entities;

use Tidy\Components\AccessControl\IClaimant;
use Tidy\Components\Events\IDispatcher;
use Tidy\Components\Events\IMessenger;
use Tidy\Components\Util\StringUtilFactory;
use Tidy\Domain\Collections\Users;
use Tidy\Domain\Events\UserActivated;
use Tidy\Domain\Events\UserRegistered;
use Tidy\Domain\Requestors\User\IActivateRequest;
use Tidy\Domain\Requestors\User\ICreateRequest;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\UserImpl;
use Tidy\Tests\Unit\Fixtures\Entities\UserStub2;

class UserTest extends MockeryTestCase
{
    const TIMMY           = self::TIMMY_FIRSTNAME;
    const PLAIN_PASS      = '$aAbB12!#';
    const TIMMY_MAIL      = 'timmy@example.com';
    const TIMMY_FIRSTNAME = 'Timmy';
    const TIMMY_LASTNAME  = 'Tungsten';

    public function testInstantiation()
    {
        $user = new UserImpl();
        $this->assertInstanceOf(IClaimant::class, $user);
        $this->assertInstanceOf(IMessenger::class, $user);
    }

    public function testRegisterWithoutImmediateAccess()
    {
        $user    = new UserImpl();
        $request = $this->makeRegisterRequestWithoutImmediateAccess();

        $users   = mock(Users::class);
        $users->expects('findByUserName')->andReturn(null);
        $user->register($request, new StringUtilFactory(), $users);

        $this->assertCount(1, $user->events());
        $event = $user->events()->dequeue();
        $this->assertInstanceOf(UserRegistered::class, $event);
        $this->assertIssUuid($event->id());
        $this->assertEquals($user->getId(), $event->id());
    }

    public function testRegisterWithImmediateAccess()
    {
        $user    = new UserImpl();
        $request = $this->makeRegisterRequestWithImmediateAccess();

        $users   = mock(Users::class);
        $users->expects('findByUserName')->andReturn(null);
        $user->register($request, new StringUtilFactory(), $users);

        $this->assertCount(2, $user->events());
        $user->events()->dequeue();
        $event = $user->events()->dequeue();
        $this->assertInstanceOf(UserActivated::class, $event);
        $this->assertEquals($user->getId(), $event->id());
    }

    public function testActivate()
    {
        $mock = mock(IActivateRequest::class);
        $mock->expects('token')->andReturn('the-token');
        $user = new UserStub2('the-token');
        $user->activate($mock);

        $this->assertCount(1, $user->events());
        $event = $user->events()->dequeue();
        $this->assertInstanceOf(UserActivated::class, $event);
        $this->assertEquals($user->getId(), $event->id());
    }



    /**
     * @return mixed|\Mockery\MockInterface
     */
    private function makeRegisterRequestWithoutImmediateAccess()
    {
        $request = $this->makeRequest();
        $request->expects('isAccessGranted')->andReturn(false);
        return $request;
    }

    private function makeRegisterRequestWithImmediateAccess() {
        $request = $this->makeRequest();
        $request->expects('isAccessGranted')->andReturn(true);
        return $request;
    }

    /**
     * @return mixed|\Mockery\MockInterface
     */
    private function makeRequest()
    {
        $request = mock(ICreateRequest::class);
        $request->allows('getUserName')->andReturn(self::TIMMY);
        $request->allows('eMail')->andReturn(self::TIMMY_MAIL);
        $request->allows('plainPassword')->andReturn(self::PLAIN_PASS);
        $request->allows('firstName')->andReturn(self::TIMMY_FIRSTNAME);
        $request->allows('lastName')->andReturn(self::TIMMY_LASTNAME);

        return $request;
    }


}