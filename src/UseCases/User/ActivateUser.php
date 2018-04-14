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

        $user = $this->userGateway->find($request->getUserId());
        $user->setEnabled(true);
        $this->userGateway->save($user);

        return $this->responseTransformer->transform($user);
    }


}