<?php
/**
 * ResetPassword.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Exceptions\NotFound;
use Tidy\Gateways\IUserGateway;
use Tidy\Responders\User\IUserResponseTransformer;
use Tidy\UseCases\User\DTO\ResetPasswordRequestDTO;

class ResetPassword extends GenericUseCase
{
    /**
     * @var IPasswordEncoder
     */
    protected $encoder;

    public function __construct(
        IPasswordEncoder $encoder,
        IUserGateway $userGateway,
        IUserResponseTransformer $responseTransformer
    )
    {
        parent::__construct($userGateway, $responseTransformer);
        $this->encoder = $encoder;
    }


    public function execute(ResetPasswordRequestDTO $request) {

        $user     = $this->userGateway->findByToken($request->getToken());
        if(! $user ) throw new NotFound(sprintf('Unable to find user ty token "%s".', $request->getToken()));

        $password = $this->encoder->encode($request->getPlainPassword(), null);
        $user->setPassword($password)->clearToken();
        $this->userGateway->save($user);

        return $this->responseTransformer->transform($user);
    }


}