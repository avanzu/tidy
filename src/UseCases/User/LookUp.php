<?php
/**
 * LookUp.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Requestors\User\ILookUpRequest;
use Tidy\Domain\Responders\User\IResponse;

class LookUp extends UseCase
{


    /**
     * @param ILookUpRequest $request
     *
     * @return IResponse
     * @throws \Tidy\Components\Exceptions\NotFound
     */
    public function execute(ILookUpRequest $request)
    {

        $user = $this->userGateway->find($request->userId());
        if (!$user) {
            throw new NotFound(sprintf('Unable to find user by identifier %s', $request->userId()));
        }

        return $this->transformer()->transform($user);
    }


}