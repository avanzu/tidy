<?php
/**
 * ActivateUser.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Requestors\User\IActivateUserRequest;

class ActivateUser extends UseCaseUser
{

    public function execute(IActivateUserRequest $request)
    {

        $user = $this->userGateway->findByToken($request->getToken());

        if (!$user) {
            throw new NotFound(sprintf('Unable to find user by token "%s".', $request->getToken()));
        }

        $user->setEnabled(true)->clearToken();

        $this->userGateway->save($user);

        return $this->responseTransformer->transform($user);
    }


}