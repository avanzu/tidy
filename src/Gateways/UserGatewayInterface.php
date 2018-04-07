<?php
/**
 * UserGatewayInterface.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Gateways;


use Tidy\Entities\User;

interface UserGatewayInterface
{

    /**
     * @param $getUserId
     *
     * @return User
     */
    public function find($getUserId);
}