<?php
/**
 * ResetPassword.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Requestors\User\IResetPasswordRequest;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\UseCases\User\Traits\TItemResponder;

class ResetPassword
{
    use TItemResponder;

    /**
     * @var IPasswordEncoder
     */
    protected $encoder;


    public function __construct(
        IPasswordEncoder $encoder,
        IUserGateway $userGateway,
        IResponseTransformer $transformer = null
    ) {
        $this->transformer = $transformer;
        $this->userGateway = $userGateway;
        $this->encoder     = $encoder;
    }


    public function execute(IResetPasswordRequest $request)
    {

        $user = $this->userGateway->findByToken($request->token());
        if (!$user) {
            throw new NotFound(sprintf('Unable to find user ty token "%s".', $request->token()));
        }

        $password = $this->encoder->encode($request->plainPassword(), null);
        $user->setPassword($password)->clearToken();
        $this->userGateway->save($user);

        return $this->transformer()->transform($user);
    }


}