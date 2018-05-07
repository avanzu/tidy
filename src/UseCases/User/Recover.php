<?php
/**
 * Recover.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\BusinessRules\UserRules;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Requestors\User\IRecoverRequest;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\UseCases\User\Traits\TItemResponder;

class Recover
{

    use TItemResponder;

    /**
     * @var UserRules
     */
    private $rules;

    /**
     * ItemResponder constructor.
     *
     * @param IUserGateway         $userGateway
     * @param UserRules            $rules
     * @param IResponseTransformer $responseTransformer
     */
    public function __construct(IUserGateway $userGateway, UserRules $rules, IResponseTransformer $responseTransformer = null)
    {
        $this->userGateway = $userGateway;
        $this->transformer = $responseTransformer;
        $this->rules = $rules;
    }


    public function execute(IRecoverRequest $request)
    {
        $user = $this->userGateway->findByUserName($request->userName());
        if (!$user) {
            throw new NotFound(sprintf('Unable to find user by username "%s".', $request->userName()));
        }

        $user->recover($request, $this->rules);

        $this->userGateway->save($user);

        return $this->transformer()->transform($user);
    }
}