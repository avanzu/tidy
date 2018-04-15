<?php
/**
 * CreateUser.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Gateways\IUserGateway;
use Tidy\Requestors\User\ICreateUserRequest;
use Tidy\Responders\User\IUserResponseTransformer;


class CreateUser extends GenericUseCase
{
    /**
     * @var IPasswordEncoder
     */
    private $passwordEncoder;

    public function __construct(
        IUserGateway $userGateway,
        IUserResponseTransformer $responseTransformer,
        IPasswordEncoder $encoder
    ) {
        parent::__construct($userGateway, $responseTransformer);
        $this->passwordEncoder = $encoder;
    }


    public function execute(ICreateUserRequest $request)
    {

        $user     = $this->userGateway->makeUser();

        $password = $this->passwordEncoder->encode($request->getPlainPassword(), null);

        $user->setUserName($request->getUserName())
             ->setEMail($request->getEMail())
             ->setPassword($password)
             ->setEnabled($request->isAccessGranted())
        ;

        if (!$request->isAccessGranted()) {
            $user->assignToken(uniqid());
        }

        $profile = $this->userGateway->makeProfile();
        $profile->setFirstName($request->getFirstName())->setLastName($request->getLastName());

        $user->assignProfile($profile);

        $this->userGateway->save($user);

        return $this->responseTransformer->transform($user);

    }




}