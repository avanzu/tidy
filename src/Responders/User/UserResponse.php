<?php
/**
 * UserResponse.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Responders\User;


interface UserResponse
{
    public function getUserName();

    public function getId();
}