<?php
/**
 * GetUser.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Exceptions\NotFound;
use Tidy\Gateways\IUserGateway;
use Tidy\Requestors\User\IGetUserRequest;
use Tidy\Responders\User\IUserResponse;
use Tidy\Responders\User\IUserResponseTransformer;

class GetUser
{
    /**
     * @var IUserResponseTransformer
     */
    private $responseTransformer;

    /**
     * @var IUserGateway
     */
    private $userGateway;

    /**
     * @param IGetUserRequest $request
     *
     * @return IUserResponse
     * @throws NotFound
     */
    public function execute(IGetUserRequest $request)
    {

        $user = $this->userGateway->find($request->getUserId());

        return $this->responseTransformer->transform($user);
    }

    /**
     * @param IUserGateway $userGateway
     */
    public function setUserGateway($userGateway)
    {
        $this->userGateway = $userGateway;
    }

    /**
     * @param IUserResponseTransformer $transformer
     */
    public function setResponseTransformer(IUserResponseTransformer $transformer)
    {
        $this->responseTransformer = $transformer;
    }


}