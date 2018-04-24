<?php
/**
 * LookUp.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Requestors\User\ILookUpRequest;
use Tidy\Domain\Responders\User\IResponse;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\UseCases\User\Traits\TItemResponder;

class LookUp
{
    use TItemResponder;

    /**
     * ItemResponder constructor.
     *
     * @param IUserGateway         $userGateway
     * @param IResponseTransformer $responseTransformer
     */
    public function __construct(IUserGateway $userGateway, IResponseTransformer $responseTransformer = null)
    {
        $this->userGateway = $userGateway;
        $this->transformer = $responseTransformer;
    }


    /**
     * @param ILookUpRequest $request
     *
     * @return IResponse
     * @throws \Tidy\Components\Exceptions\NotFound
     */
    public function execute(ILookUpRequest $request)
    {

        $user = $this->userGateway->find($request->userId());
        if (!$user) {
            throw new NotFound(sprintf('Unable to find user by identifier %s', $request->userId()));
        }

        return $this->transformer()->transform($user);
    }


}