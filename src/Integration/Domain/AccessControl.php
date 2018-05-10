<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 10.05.18
 *
 */

namespace Tidy\Integration\Domain;

use Tidy\Components\AccessControl\AccessControlBroker;
use Tidy\Components\DependencyInjection\Container;
use Tidy\Integration\Components\Components;

class AccessControl extends Container
{

    const ACL_BROKER = 'acl_broker';

    /**
     * @var Components
     */
    protected $components;

    /**
     * @var Gateways
     */
    protected $gateways;

    public function __construct(Components $components, Gateways $gateways)
    {
        $this->components = $components;
        $this->gateways   = $gateways;
    }


    /**
     * @return AccessControlBroker
     */
    public function broker()
    {
        if (!$this->contains(self::ACL_BROKER)) {
            $this->attach(self::ACL_BROKER, $this->components->accessControlBroker($this->gateways->users()));
        }

        return $this->reveal(self::ACL_BROKER);
    }
}