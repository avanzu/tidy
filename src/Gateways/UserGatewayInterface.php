<?php
/**
 * UserGatewayInterface.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Gateways;


use Tidy\Entities\User;
use Tidy\Exceptions\NotFound;

interface UserGatewayInterface
{

    /**
     * @param $getUserId
     *
     * @return User
     * @throws NotFound
     */
    public function find($getUserId);

    public function fetchCollection($page, $pageSize);
}