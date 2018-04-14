<?php
/**
 * GetUser.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Exceptions\NotFound;
use Tidy\Requestors\User\IGetUserRequest;
use Tidy\Responders\User\IUserResponse;

class GetUser extends GenericUseCase
{


    /**
     * @param IGetUserRequest $request
     *
     * @return IUserResponse
     * @throws NotFound
     */
    public function execute(IGetUserRequest $request)
    {

        $user = $this->userGateway->find($request->getUserId());

        return $this->responseTransformer->transform($user);
    }


}