<?php
/**
 * GetUserRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Requestors\User\IGetUserRequest;

/**
 * Class GetUserRequestDTO
 */
class GetUserRequestDTO implements IGetUserRequest
{

    /**
     * @var
     */
    public $userId;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return GetUserRequestDTO
     */
    public static function make()
    {
        return new static;
    }

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
}