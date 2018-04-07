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
}