<?php
/**
 * CreateUser.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Gateways\IUserGateway;
use Tidy\Responders\User\IUserResponseTransformer;
use Tidy\UseCases\User\DTO\CreateUserRequestDTO;
use Tidy\UseCases\User\DTO\ICreateUserRequest;

class CreateUser
{
    /**
     * @var IPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * @var IUserResponseTransformer
     */
    private $responseTransformer;
    /**
     * @var IUserGateway
     */
    private $userGateway;

    /**
     * CreateUser constructor.
     *
     * @param IPasswordEncoder $passwordEncoder
     */
    public function __construct(IPasswordEncoder $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function execute(ICreateUserRequest $request)
    {

            $user     = $this->userGateway->produce();
            $password = $this->passwordEncoder->encode($request->getPlainPassword(), null);

            $user->setUserName($request->getUserName())
                 ->setEMail($request->getEMail())
                ->setPassword($password)
                ->setEnabled($request->isAccessGranted())
            ;

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