<?php
/**
 * IActivateUserRequest.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Requestors\User;

interface IActivateUserRequest
{
    public function withToken($token);

    public function getToken();
}