<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Integration\Components;

use Tidy\Components\AccessControl\AccessControlBroker;
use Tidy\Components\AccessControl\IClaimantProvider;
use Tidy\Components\DependencyInjection\Container;
use Tidy\Components\Events\EventDispatcher;
use Tidy\Components\Events\IDispatcher;
use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Components\Util\StringUtilFactory;

class Components extends Container
{


    const STRING_UTILS = 'string_utils';

    const EVENT_DISPATCHER = 'event_dispatcher';

    /**
     * @var IStringUtilFactory
     */
    protected $stringUtilFactory;

    /**
     * @var IDispatcher
     */
    protected $eventDispatcher;

    protected $instances;

    const ACL_BROKER = 'acl_broker';

    public function __construct(
        IStringUtilFactory $stringUtilFactory = null,
        IDispatcher $dispatcher = null,
        AccessControlBroker $broker = null
    ) {
        if ($stringUtilFactory) {
            $this->attach(self::STRING_UTILS, $stringUtilFactory);
        }
        if ($dispatcher) {
            $this->attach(self::EVENT_DISPATCHER, $dispatcher);
        }
        if ($broker) {
            $this->attach(self::ACL_BROKER, $broker);
        }

    }

    /**
     * @return IStringUtilFactory
     */
    public function stringUtilFactory()
    {
        if (!$this->contains(self::STRING_UTILS)) {
            $this->attach(self::STRING_UTILS, new StringUtilFactory());
        }

        return $this->reveal(self::STRING_UTILS);
    }

    /**
     * @return IDispatcher
     */
    public function eventDispatcher()
    {
        if (!$this->contains(self::EVENT_DISPATCHER)) {
            $this->attach(self::EVENT_DISPATCHER, new EventDispatcher());
        }

        return $this->reveal(self::EVENT_DISPATCHER);
    }

    public function accessControlBroker(IClaimantProvider $provider)
    {
        if (!$this->contains(self::ACL_BROKER)) {
            $this->attach(self::ACL_BROKER, new AccessControlBroker($provider));
        }

        return $this->reveal(self::ACL_BROKER);
    }
}