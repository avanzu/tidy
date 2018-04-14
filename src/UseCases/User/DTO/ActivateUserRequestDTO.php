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

    public $token;

    public static function make()
    {
        return new self;
    }

    public function withToken($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }
}