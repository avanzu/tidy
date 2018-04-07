<?php
/**
 * UserResponseDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Responders\User\UserResponse;

class UserResponseDTO implements UserResponse
{

    public $id;
    public $userName;



    public function getId()
    {
        return $this->id;
    }

    public function getUserName()
    {
        return $this->userName;
    }
}