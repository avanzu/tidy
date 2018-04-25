<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\User\DTO;

class RecoverRequestBuilder
{
    protected $userName;

    public function withUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    public function build()
    {
        return new RecoverRequestDTO($this->userName);
    }
}