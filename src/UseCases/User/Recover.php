<?php
/**
 * Recover.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Requestors\User\IRecoverRequest;
use Tidy\Domain\Responders\User\ChangeResponder;

class Recover extends ChangeResponder
{
    public function execute(IRecoverRequest $request)
    {
        $user = $this->userGateway->findByUserName($request->userName());
        if (!$user) {
            throw new NotFound(sprintf('Unable to find user by username "%s".', $request->userName()));
        }

        $user->assignToken(uniqid());
        $this->userGateway->save($user);
        $result = ChangeSet::make(Change::add($user->getToken(), 'token'));

        return $this->transformer()->transform($result);
    }
}