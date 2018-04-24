<?php
/**
 * ResetPasswordRequestDTO.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Domain\Requestors\User\IResetPasswordRequest;

class ResetPasswordRequestDTO implements IResetPasswordRequest
{
    public $token;

    public $plainPassword;

    public static function make()
    {
        return new self;
    }

    public function plainPassword()
    {
        return $this->plainPassword;
    }

    public function token()
    {
        return $this->token;
    }

    public function withPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    public function withToken($token)
    {
        $this->token = $token;

        return $this;
    }

}