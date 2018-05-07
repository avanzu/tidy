<?php
/**
 * Activate.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\BusinessRules\UserRules;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Requestors\User\IActivateRequest;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\UseCases\User\Traits\TItemResponder;

class Activate
{

    use TItemResponder;

    /**
     * @var UserRules
     */
    private $userRules;

    /**
     * ItemResponder constructor.
     *
     * @param IUserGateway $userGateway
     * @param UserRules $userRules
     * @param IResponseTransformer $responseTransformer
     */
    public function __construct(
        IUserGateway $userGateway,
        UserRules $userRules,
        IResponseTransformer $responseTransformer = null
    ) {
        $this->userGateway = $userGateway;
        $this->transformer = $responseTransformer;
        $this->userRules   = $userRules;
    }


    /**
     * @param IActivateRequest $request
     *
     * @return \Tidy\Domain\Responders\User\IResponse
     */
    public function execute(IActivateRequest $request)
    {

        $user = $this->userGateway->findByToken($request->token());

        if (!$user) {
            throw new NotFound(sprintf('Unable to find user by token "%s".', $request->token()));
        }

        $user->activate($request, $this->userRules);

        $this->userGateway->save($user);

        return $this->transformer()->transform($user);
    }


}