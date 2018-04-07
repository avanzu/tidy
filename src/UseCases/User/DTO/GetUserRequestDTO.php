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
}