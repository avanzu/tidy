<?php
/**
 * ResetPassword.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Requestors\User\IResetPasswordRequest;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\UseCases\User\Traits\TItemResponder;

class ResetPassword {
    use TItemResponder;

    /**
     * @var IPasswordEncoder
     */
    protected $encoder;
    /**
     * @var IStringUtilFactory
     */
    protected $factory;


    public function __construct(
        IStringUtilFactory $factory,
        IUserGateway $userGateway,
        IResponseTransformer $transformer = NULL
    ) {
        $this->transformer = $transformer;
        $this->userGateway = $userGateway;
        $this->factory     = $factory;
    }


    public function execute(IResetPasswordRequest $request) {

        $user = $this->userGateway->findByToken($request->token());
        if (!$user) {
            throw new NotFound(sprintf('Unable to find user ty token "%s".', $request->token()));
        }
        $user->resetPassword($request, $this->factory);
        $this->userGateway->save($user);

        return $this->transformer()->transform($user);
    }


}