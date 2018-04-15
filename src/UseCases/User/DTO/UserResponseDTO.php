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
    public function getEMail()
    {
        return $this->eMail;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }


}