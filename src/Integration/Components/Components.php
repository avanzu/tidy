<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Integration\Components;

use Tidy\Components\Collection\ObjectMap;
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

    public function __construct(IStringUtilFactory $stringUtilFactory = null, IDispatcher $dispatcher = null)
    {
        if( $stringUtilFactory) $this->attach(self::STRING_UTILS, $stringUtilFactory);
        if( $dispatcher) $this->attach(self::EVENT_DISPATCHER, $dispatcher);

    }

    public function stringUtilFactory()
    {
        if (!$this->contains(self::STRING_UTILS)) {
            $this->attach(self::STRING_UTILS, new StringUtilFactory());
        }

        return $this->reveal(self::STRING_UTILS);
    }

    public function eventDispatcher()
    {
        if (!$this->contains(self::EVENT_DISPATCHER)) {
            $this->attach(self::EVENT_DISPATCHER, new EventDispatcher());
        }

        return $this->reveal(self::EVENT_DISPATCHER);
    }
}