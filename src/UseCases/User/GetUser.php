<?php
/**
 * GetUser.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Requestors\User\IGetUserRequest;
use Tidy\Domain\Responders\User\IUserResponse;

class GetUser extends UseCaseUser
{


    /**
     * @param IGetUserRequest $request
     *
     * @return IUserResponse
     * @throws \Tidy\Components\Exceptions\NotFound
     */
    public function execute(IGetUserRequest $request)
    {

        $user = $this->userGateway->find($request->userId());
        if (!$user) {
            throw new NotFound(sprintf('Unable to find user by identifier %s', $request->userId()));
        }

        return $this->transformer()->transform($user);
    }


}