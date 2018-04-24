<?php
/**
 * Activate.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Requestors\User\IActivateRequest;
use Tidy\Domain\Responders\User\ItemResponder;

class Activate extends ItemResponder
{

    /**
     * @param IActivateRequest $request
     *
     * @return \Tidy\Domain\Responders\User\IResponse
     */
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