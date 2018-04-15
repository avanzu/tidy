<?php
/**
 * UserResponseDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Domain\Responders\User\IUserResponse;

/**
 * Class UserResponseDTO
 */
class UserResponseDTO implements IUserResponse
{

    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $userName;

    public $eMail;
    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $enabled = false;

    public $token;

    public $firstName;

    public $lastName;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getEMail()
    {
        return $this->eMail;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }


}