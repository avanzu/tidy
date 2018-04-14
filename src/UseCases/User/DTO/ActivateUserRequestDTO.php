<?php
/**
 * ActivateUserRequestDTO.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User\DTO;


class ActivateUserRequestDTO
{
    public $userId;

    public static function make()
    {
        return new self;
    }

    /**
     * @param $id
     *
     * @return ActivateUserRequestDTO
     */
    public function withUserId($id) {
        $this->userId = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

}