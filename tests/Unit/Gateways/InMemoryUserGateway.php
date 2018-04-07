<?php
/**
 * InMemoryUserGateway.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\Gateways;


use Tidy\Entities\User;
use Tidy\Exceptions\NotFound;
use Tidy\Gateways\UserGatewayInterface;

class InMemoryUserGateway implements UserGatewayInterface
{

    public static $users = [];

    /**
     * InMemoryUserGateway constructor.
     */
    public function __construct() {
        self::$users = [];
    }



    /**
     * @param $getUserId
     *
     * @return User
     * @throws NotFound
     */
    public function find($getUserId)
    {
        if(isset(self::$users[$getUserId])) {
            return self::$users[$getUserId];
        }

        throw new NotFound('User not found.');
    }
}