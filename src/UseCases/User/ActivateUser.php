<?php
/**
 * ActivateUser.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Gateways\IUserGateway;
use Tidy\Responders\User\IUserResponseTransformer;
use Tidy\UseCases\User\DTO\ActivateUserRequestDTO;

class ActivateUser
{
    /**
     * @var IUserGateway
     */
    protected $gateway;

    /**
     * @var IUserResponseTransformer
     */
    protected $transformer;

    public function execute(ActivateUserRequestDTO $request)
    {

        $user = $this->gateway->find($request->getUserId());
        $user->setEnabled(true);
        $this->gateway->save($user);

        return $this->transformer->transform($user);
    }

    public function setUserGateway($gateway)
    {
        $this->gateway = $gateway;
    }

    public function setResponseTransformer($transformer)
    {
        $this->transformer = $transformer;
    }
}