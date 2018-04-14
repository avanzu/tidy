<?php
/**
 * IUserResponse.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Responders\User;


interface IUserResponse
{
    public function getUserName();

    public function getId();

    public function getEMail();

    public function getPassword();

    public function isEnabled();
}