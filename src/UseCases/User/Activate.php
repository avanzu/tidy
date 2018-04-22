<?php
/**
 * Activate.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Requestors\User\IActivateRequest;

class Activate extends UseCaseUser
{

    public function execute(IActivateRequest $request)
    {

        $user = $this->userGateway->findByToken($request->token());

        if (!$user) {
            throw new NotFound(sprintf('Unable to find user by token "%s".', $request->token()));
        }

        $user->setEnabled(true)->clearToken();

        $this->userGateway->save($user);

        return $this->transformer()->transform($user);
    }


}