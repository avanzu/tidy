<?php
/**
 * CreateUser.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Entities\User;
use Tidy\Entities\UserProfile;
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


        $password = $this->hashPassword($request);
        $user     = $this->makeUser($request, $password);
        $profile  = $this->makeProfileForUser($user, $request);

        if (!$request->isAccessGranted()) {
            $user->assignToken(uniqid());
        }

        $this->userGateway->save($user);

        return $this->responseTransformer->transform($user);

    }

    /**
     * @param ICreateUserRequest $request
     * @param                    $password
     *
     * @return \Tidy\Entities\User
     */
    private function makeUser(ICreateUserRequest $request, $password)
    {
        $user = $this->userGateway->makeUser();
        $user->setUserName($request->getUserName())
             ->setEMail($request->getEMail())
             ->setPassword($password)
             ->setEnabled($request->isAccessGranted())
        ;

        return $user;
    }

    /**
     * @param User               $user
     * @param ICreateUserRequest $request
     *
     * @return UserProfile
     */
    private function makeProfileForUser(User $user, ICreateUserRequest $request)
    {
        $profile = $this->userGateway->makeProfile();
        $profile->setFirstName($request->getFirstName())->setLastName($request->getLastName());

        $user->assignProfile($profile);

        return $profile;
    }

    /**
     * @param ICreateUserRequest $request
     *
     * @return string
     */
    private function hashPassword(ICreateUserRequest $request)
    {
        $password = $this->passwordEncoder->encode($request->getPlainPassword(), null);

        return $password;
    }


}