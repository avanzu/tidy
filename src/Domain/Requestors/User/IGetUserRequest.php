<?php
/**
 * GetUserRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Requestors\User;


interface IGetUserRequest
{
    /**
     * @return int
     */
    public function userId();
}