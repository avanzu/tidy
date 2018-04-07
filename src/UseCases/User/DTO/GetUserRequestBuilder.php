<?php
/**
 * GetUserRequestBuilder.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;
use Tidy\Requestors\User\GetUserRequest;
use Tidy\Requestors\User\GetUserRequestBuilder as Builder;

class GetUserRequestBuilder implements Builder
{

    /**
     * @var GetUserRequestDTO
     */
    private $request;

    private function getRequest()
    {
        if( ! $this->request ) $this->create();
        return $this->request;
    }

    /**
     * @return Builder
     */
    public function create()
    {
        $this->request = new GetUserRequestDTO();
        return $this;
    }

    /**
     * @param $userId
     *
     * @return Builder
     */
    public function withUserId($userId)
    {
        $this->getRequest()->userId = $userId;
        return $this;
    }

    /**
     * @return GetUserRequest
     */
    public function build()
    {
        return $this->getRequest();
    }
}