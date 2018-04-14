<?php
/**
 * CreateUser.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Requestors\User\ICreateUserRequest;


class CreateUser extends GenericUseCase
{
    /**
     * @var IPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * CreateUser constructor.
     *
     * @param IPasswordEncoder $passwordEncoder
     */
    public function __construct(IPasswordEncoder $passwordEncoder)
    {
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


}