<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Domain\Collections;

use Tidy\Domain\Gateways\IUserGateway;

class Users
{
    /**
     * @var IUserGateway
     */
    protected $gateway;

    /**
     * Users constructor.
     *
     * @param IUserGateway $gateway
     */
    public function __construct(IUserGateway $gateway) {
        $this->gateway = $gateway;
    }

    public function findByUserName($userName) {
        return $this->gateway->findByUserName($userName);
    }

}