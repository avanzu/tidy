<?php
/**
 * CreateUserRequestDTO.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Domain\Requestors\User\ICreateUserRequest;

class CreateUserRequestDTO implements ICreateUserRequest
{
    public $userName;
    public $plainPassword;
    public $eMail;
    public $enabled = false;
    public $firstName;
    public $lastName;

    /**
     * @return ICreateUserRequest
     */
    public static function make()
    {
        return new static;
    }

    public function eMail()
    {
        return $this->eMail;
    }

    public function firstName()
    {
        return $this->firstName;
    }

    public function lastName()
    {
        return $this->lastName;
    }

    public function plainPassword()
    {
        return $this->plainPassword;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function grantImmediateAccess()
    {
        $this->enabled = true;

        return $this;
    }

    public function isAccessGranted()
    {
        return (bool)$this->enabled;
    }

    public function witFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function withEMail($eMail)
    {
        $this->eMail = $eMail;

        return $this;
    }

    public function withLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function withPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function withUserName($username)
    {
        $this->userName = $username;

        return $this;
    }


}