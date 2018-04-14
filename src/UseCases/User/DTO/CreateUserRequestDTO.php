<?php
/**
 * CreateUserRequestDTO.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Requestors\User\ICreateUserRequest;

class CreateUserRequestDTO implements ICreateUserRequest
{
    public    $userName;
    public    $plainPassword;
    public    $eMail;
    protected $enabled = false;

    /**
     * @return ICreateUserRequest
     */
    public static function make()
    {
        return new static;
    }

    public function withUserName($username)
    {
        $this->userName = $username;

        return $this;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function withPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function withEMail($eMail)
    {
        $this->eMail = $eMail;

        return $this;
    }

    public function getEMail() {
        return $this->eMail;
    }

    public function getPlainPassword() {
        return $this->plainPassword;
    }

    public function grantImmediateAccess() {
        $this->enabled = true;
        return $this;
    }

    public function isAccessGranted()
    {
        return (bool)$this->enabled;
    }

}