<?php
/**
 * UserStub1.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\Domain\Entities;


use Tidy\Domain\Entities\User;

class UserStub1 extends User
{
    const ID = 123;
    const USERNAME = 'Bob';

    protected $id = self::ID;
    protected $userName = self::USERNAME;



}