<?php
/**
 * TimmyUser.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\Fixtures\Entities;


class TimmyUser extends UserImpl
{
    const ID       = 998811;
    const USERNAME = 'timmy';
    const EMAIL    = 'timmy@example.com';

    protected $id       = self::ID;

    protected $userName = self::USERNAME;

    protected $eMail    = self::EMAIL;


}