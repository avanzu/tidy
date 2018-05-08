<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 07.05.18
 *
 */

namespace Tidy\Domain\Gateways;

use Tidy\Components\Events\IDispatcher;
use Tidy\Components\Events\TBroadcast;
use Tidy\Domain\Entities\User;

abstract class UserGateway implements IUserGateway
{

    use TBroadcast;

    /**
     * UserGateway constructor.
     *
     * @param IDispatcher $dispatcher
     */
    public function __construct(IDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }


    /**
     * @param User $user
     *
     * @return mixed|void
     */
    public function save(User $user)
    {
        $this->doSave($user);
        $this->broadcast($user);
    }



    abstract protected function doSave(User $user);


}