<?php
/**
 * Activate.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Requestors\User\IActivateRequest;
use Tidy\Domain\Responders\Audit\ChangeResponse;
use Tidy\Domain\Responders\User\ChangeResponder;

class Activate extends ChangeResponder
{

    /**
     * @param IActivateRequest $request
     *
     * @return ChangeResponse
     */
    public function execute(IActivateRequest $request)
    {

        $user = $this->userGateway->findByToken($request->token());

        if (!$user) {
            throw new NotFound(sprintf('Unable to find user by token "%s".', $request->token()));
        }

        $result = ChangeSet::make()
                           ->add(Change::test($request->token(), 'token'))
                           ->add(Change::replace(true, 'enabled'))
                           ->add(Change::remove( 'token'))
        ;

        $user->setEnabled(true)->clearToken();

        $this->userGateway->save($user);

        return $this->transformer()->transform($result);
    }


}