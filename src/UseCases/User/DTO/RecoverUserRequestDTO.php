<?php
/**
 * RecoverUserRequestDTO.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User\DTO;


class RecoverUserRequestDTO
{
    public $userName;

    public static function make()
    {
        return new static;
    }

    public function withUserName($userName)
    {
        $this->userName = $userName;
        return $this;
    }



    public function getUserName() {
        return $this->userName;
    }

}