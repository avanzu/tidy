<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\User\DTO;

class ActivateRequestBuilder
{

    protected $token;

    public function withToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function build()
    {
        return new ActivateRequestDTO($this->token);
    }
}