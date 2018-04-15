<?php
/**
 * GetUser.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Domain\Requestors\User\IGetUserRequest;
use Tidy\Domain\Responders\User\IUserResponse;

class GetUser extends GenericUseCase
{


    /**
     * @param IGetUserRequest $request
     *
     * @return IUserResponse
     * @throws \Tidy\Components\Exceptions\NotFound
     */
    public function execute(IGetUserRequest $request)
    {

        $user = $this->userGateway->find($request->getUserId());

        return $this->responseTransformer->transform($user);
    }


}