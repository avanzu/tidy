<?php
/**
 * ActivateUserRequestDTO.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Requestors\User\IActivateUserRequest;

class ActivateUserRequestDTO implements IActivateUserRequest
{
    public $userId;

    public static function make()
    {
        return new self;
    }

    public function withUserId($id) {
        $this->userId = $id;
        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

}