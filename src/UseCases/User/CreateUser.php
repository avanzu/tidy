<?php
/**
 * CreateUser.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Gateways\IUserGateway;
use Tidy\Responders\User\IUserResponseTransformer;
use Tidy\UseCases\User\DTO\CreateUserRequestDTO;

class CreateUser
{
    /**
     * @var IUserResponseTransformer
     */
    private $responseTransformer;
    /**
     * @var IUserGateway
     */
    private $userGateway;


    public function execute(CreateUserRequestDTO $request)
    {

            $user = $this->userGateway->produce();

            $user->setUserName($request->getUserName());

            $this->userGateway->save($user);

            return $this->responseTransformer->transform($user);

    }

    public function setUserGateway($userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function setResponseTransformer($responseTransformer)
    {
        $this->responseTransformer = $responseTransformer;

    }
}