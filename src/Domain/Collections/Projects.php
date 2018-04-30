<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 30.04.18
 *
 */

namespace Tidy\Domain\Collections;

use Tidy\Domain\Gateways\IProjectGateway;

class Projects
{
    /**
     * @var IProjectGateway
     */
    protected $gateway;

    /**
     * Projects constructor.
     *
     * @param IProjectGateway $gateway
     */
    public function __construct(IProjectGateway $gateway) { $this->gateway = $gateway; }

    public function findByCanonical($canonical) { 
        return $this->gateway->findByCanonical($canonical);
    }


}