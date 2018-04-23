<?php
/**
 * Create.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Domain\Entities\User;
use Tidy\Domain\Entities\UserProfile;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Requestors\User\ICreateRequest;
use Tidy\Domain\Responders\User\IResponseTransformer;


class Create extends UseCase
{
    /**
     * @var IPasswordEncoder
     */
    private $passwordEncoder;

    public function __construct(
        IUserGateway $userGateway,
        IPasswordEncoder $encoder,
        IResponseTransformer $responseTransformer = null
    ) {
        parent::__construct($userGateway, $responseTransformer);
        $this->passwordEncoder = $encoder;
    }


    public function execute(ICreateRequest $request)
    {


        $password = $this->hashPassword($request);
        $user     = $this->makeUser($request, $password);
        $profile  = $this->makeProfileForUser($user, $request);

        if (!$request->isAccessGranted()) {
            $user->assignToken(uniqid());
        }

        $this->userGateway->save($user);

        return $this->transformer()->transform($user);

    }

    /**
     * @param ICreateRequest     $request
     * @param                    $password
     *
     * @return \Tidy\Domain\Entities\User
     */
    private function makeUser(ICreateRequest $request, $password)
    {
        $user = $this->userGateway->makeUser();
        $user->setUserName($request->getUserName())
             ->setEMail($request->eMail())
             ->setPassword($password)
             ->setEnabled($request->isAccessGranted())
        ;

        return $user;
    }

    /**
     * @param User           $user
     * @param ICreateRequest $request
     *
     * @return UserProfile
     */
    private function makeProfileForUser(User $user, ICreateRequest $request)
    {
        $profile = $this->userGateway->makeProfile();
        $profile->setFirstName($request->firstName())->setLastName($request->lastName());

        $user->assignProfile($profile);

        return $profile;
    }

    /**
     * @param ICreateRequest $request
     *
     * @return string
     */
    private function hashPassword(ICreateRequest $request)
    {
        $password = $this->passwordEncoder->encode($request->plainPassword(), null);

        return $password;
    }


}