<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\User\DTO;

class LookUpRequestBuilder
{

    /**
     * @var
     */
    protected $userId;

    /**
     * @param $userId
     *
     * @return $this
     */
    public function withUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function build()
    {
        return new LookUpRequestDTO($this->userId);
    }
}