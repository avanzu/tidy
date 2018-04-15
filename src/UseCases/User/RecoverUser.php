<?php
/**
 * RecoverUser.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Exceptions\NotFound;
use Tidy\UseCases\User\DTO\RecoverUserRequestDTO;

class RecoverUser extends GenericUseCase
{
    public function execute(RecoverUserRequestDTO $request)
    {
        $user = $this->userGateway->findByUserName($request->getUserName());
        if( ! $user )
            throw new NotFound(sprintf('Unable to find user by username "%s".', $request->getUserName()));

        $user->assignToken(uniqid());
        $this->userGateway->save($user);

        return $this->responseTransformer->transform($user);
    }
}