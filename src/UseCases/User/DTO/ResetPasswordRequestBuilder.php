<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\User\DTO;

class ResetPasswordRequestBuilder
{

    protected $plainPassword;

    protected $token;

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

    public function build()
    {
        return new ResetPasswordRequestDTO($this->token, $this->plainPassword);
    }
}