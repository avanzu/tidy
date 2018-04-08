<?php
/**
 * CreateUserRequestDTO.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\UseCases\User\DTO;


class CreateUserRequestDTO
{
    public $userName;

    /**
     * @return CreateUserRequestDTO
     */
    public static function create()
    {
        return new static;
    }

    public function withUserName($username) {
        $this->userName = $username;
        return $this;
    }

    public function getUserName() {
        return $this->userName;
    }
}