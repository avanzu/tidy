<?php
/**
 * ResetPassword.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Requestors\User\IResetPasswordRequest;
use Tidy\Domain\Responders\Audit\IChangeResponseTransformer;
use Tidy\Domain\Responders\User\ChangeResponder;

class ResetPassword extends ChangeResponder
{
    /**
     * @var IPasswordEncoder
     */
    protected $encoder;

    public function __construct(
        IPasswordEncoder $encoder,
        IUserGateway $userGateway,
        IChangeResponseTransformer $transformer = null
    ) {
        parent::__construct($userGateway, $transformer);
        $this->encoder = $encoder;
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

        $result = ChangeSet::make(
            Change::replace('**********', 'password' ),
            Change::remove('token')
        );


        return $this->transformer()->transform($result);
    }


}