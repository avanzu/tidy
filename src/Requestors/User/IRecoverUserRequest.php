<?php
/**
 * IRecoverUserRequest.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\Requestors\User;

interface IRecoverUserRequest
{
    public function withUserName($userName);

    public function getUserName();
}