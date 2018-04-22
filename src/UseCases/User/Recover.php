<?php
/**
 * Recover.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Requestors\User\IRecoverRequest;

class Recover extends UseCaseUser
{
    public function execute(IRecoverRequest $request)
    {
        $user = $this->userGateway->findByUserName($request->userName());
        if (!$user) {
            throw new NotFound(sprintf('Unable to find user by username "%s".', $request->userName()));
        }

        $user->assignToken(uniqid());
        $this->userGateway->save($user);

        return $this->transformer()->transform($user);
    }
}