<?php
/**
 * UserStub2.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\Entities;


use Tidy\Entities\User;

class UserStub2 extends User
{
    const ID       = 999;
    const USERNAME = 'John';

    protected $id       = self::ID;
    protected $userName = self::USERNAME;


}