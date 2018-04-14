<?php
/**
 * ActivateUser.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Requestors\User\IActivateUserRequest;

class ActivateUser extends GenericUseCase
{

    public function execute(IActivateUserRequest $request)
    {

        $user = $this->userGateway->find($request->getToken());

        $user->setEnabled(true)
             ->setToken(null);

        $this->userGateway->save($user);

        return $this->responseTransformer->transform($user);
    }


}