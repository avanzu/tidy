<?php
/**
 * Create.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Domain\BusinessRules\UserRules;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Requestors\User\ICreateRequest;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\UseCases\User\Traits\TItemResponder;

class Create
{
    use TItemResponder;


    /**
     * @var IStringUtilFactory
     */
    private $factory;

    /**
     * @var UserRules
     */
    private $rules;

    public function __construct(
        IUserGateway $userGateway,
        UserRules $rules,
        IStringUtilFactory $factory,
        IResponseTransformer $responseTransformer = null
    ) {
        $this->userGateway = $userGateway;
        $this->transformer = $responseTransformer;
        $this->rules = $rules;
        $this->factory = $factory;
    }


    public function execute(ICreateRequest $request)
    {

        $user = $this->userGateway->makeUser();
        $user->register($request, $this->rules, $this->factory);
        $this->userGateway->save($user);

        return $this->transformer()->transform($user);

    }


}