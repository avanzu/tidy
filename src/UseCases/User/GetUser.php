<?php
/**
 * GetUser.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Exceptions\NotFound;
use Tidy\Gateways\UserGatewayInterface;
use Tidy\Requestors\User\GetUserRequest;
use Tidy\Responders\User\UserResponseTransformer;

class GetUser
{
    /**
     * @var UserResponseTransformer
     */
    private $responseTransformer;

    /**
     * @var UserGatewayInterface
     */
    private $userGateway;

    /**
     * @param GetUserRequest $request
     *
     * @return \Tidy\Responders\User\UserResponse
     * @throws NotFound
     */
    public function execute(GetUserRequest $request) {

        $user = $this->userGateway->find($request->getUserId());
        if( !$user )
            throw new NotFound('User not found.');

        return $this->responseTransformer->transform($user);
    }

    /**
     * @param UserGatewayInterface $userGateway
     */
    public function setUserGateway($userGateway) {
        $this->userGateway = $userGateway;
    }

    /**
     * @param UserResponseTransformer $transformer
     */
    public function setResponseTransformer($transformer) {
        $this->responseTransformer = $transformer;
    }


}