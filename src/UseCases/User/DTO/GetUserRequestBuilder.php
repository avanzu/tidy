<?php
/**
 * GetUserRequestBuilder.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Requestors\User\IGetUserRequest;
use Tidy\Requestors\User\IGetUserRequestBuilder as Builder;

/**
 * Class GetUserRequestBuilder
 */
class GetUserRequestBuilder implements Builder
{

    /**
     * @var GetUserRequestDTO
     */
    private $request;

    /**
     * @return IGetUserRequest
     */
    public function build()
    {
        return $this->getRequest();
    }

    /**
     * @return GetUserRequestDTO
     */
    private function getRequest()
    {
        if (!$this->request) {
            $this->create();
        }

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


}