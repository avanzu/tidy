<?php
/**
 * GetUserRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Requestors\User;


interface IGetUserRequest
{
    /**
     * @return int
     */
    public function getUserId();
}