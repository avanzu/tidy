<?php
/**
 * GetUserRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Requestors\User\GetUserRequest;

class GetUserRequestDTO implements GetUserRequest
{

    public  $userId;

    public function getUserId() {
        return $this->userId;
    }
}