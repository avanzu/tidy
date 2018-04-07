<?php
/**
 * GetUserRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Requestors\User;


interface GetUserRequest
{
    /**
     * @return int
     */
    public function getUserId();
}