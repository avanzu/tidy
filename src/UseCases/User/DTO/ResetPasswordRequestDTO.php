<?php
/**
 * ResetPasswordRequestDTO.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User\DTO;


class ResetPasswordRequestDTO
{
    public    $token;
    public $plainPassword;

    public static function make()
    {
        return new self;
    }

    /**
     * @param $token
     *
     * @return $this
     */
    public function withToken($token) {
        $this->token = $token;
        return $this;
    }

    public function getToken() {
        return $this->token;
    }

    public function withPlainPassword($password)
    {
        $this->plainPassword = $password;
        return $this;
    }

    public function getPlainPassword() {
        return $this->plainPassword;
    }

}