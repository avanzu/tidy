<?php
/**
 * Create.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Components\Util\StringConverter;
use Tidy\Domain\Collections\Users;
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

    public function __construct(
        IUserGateway $userGateway,
        IStringUtilFactory $factory,
        IResponseTransformer $responseTransformer = null
    ) {
        $this->userGateway = $userGateway;
        $this->transformer = $responseTransformer;
        $this->factory     = $factory;
    }


    public function execute(ICreateRequest $request)
    {

        $user = $this->userGateway->makeUser();
        $user->register($request, $this->factory, new Users($this->userGateway));
        $this->userGateway->save($user);

        return $this->transformer()->transform($user);

    }


}