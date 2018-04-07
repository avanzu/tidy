<?php
/**
 * IUserGateway.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Gateways;


use Tidy\Entities\User;
use Tidy\Exceptions\NotFound;

interface IUserGateway
{

    /**
     * @param $getUserId
     *
     * @return User
     * @throws NotFound
     */
    public function find($getUserId);

    /**
     * @param $page
     * @param $pageSize
     *
     * @return User
     */
    public function fetchCollection($page, $pageSize);

    /**
     * @return int
     */
    public function getTotal();
}