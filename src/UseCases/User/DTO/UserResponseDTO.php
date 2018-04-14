<?php
/**
 * UserResponseDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Responders\User\IUserResponse;

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

    public    $eMail;
    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $enabled = false;


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


}