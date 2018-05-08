<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\Components\Events;

class Dispatcher implements IDispatcher
{
    protected $handlers = [];

    /**
     * @param $eventName
     * @param $handler
     */
    public function addHandler($eventName, $handler)
    {
        $this->ensureKey($eventName)->handlers[$eventName][spl_object_hash($handler)] = $handler;
    }

    /**
     * @param $eventName
     * @param $handler
     */
    public function removeHandler($eventName, $handler)
    {
        $this->handlers[$eventName] = array_filter(
            $this->handlers[$eventName],
            function ($candidate) use ($handler) {
                return !($candidate === $handler);
            }
        );
    }


    /**
     * @param $eventName
     */
    public function clear($eventName)
    {
        if ($this->hasHandlersFor($eventName)) {
            $this->handlers[$eventName] = [];
        }
    }

    /**
     * @param IEvent $event
     *
     * @return IEvent
     */
    public function broadcast(IEvent $event)
    {
        $handlerName = $this->getEventHandlerNameFor($event);
        foreach ($this->handlersFor($handlerName) as $handler) {
            if (method_exists($handler, $handlerName)) {
                $handler->$handlerName($event);
            }
        }

        return $event;

    }

    /**
     * @param $eventName
     *
     * @return array|mixed
     */
    public function handlersFor($eventName)
    {
        return isset($this->handlers[$eventName]) ? $this->handlers[$eventName] : [];
    }

    /**
     * @param $eventName
     *
     * @return bool
     */
    public function hasHandlersFor($eventName)
    {
        return (isset($this->handlers[$eventName]) && count($this->handlers[$eventName]) > 0);
    }

    /**
     * @param IEvent $event
     *
     * @return string
     */
    protected function getEventHandlerNameFor(IEvent $event)
    {
        $fqn  = get_class($event);
        $name = substr($fqn, strrpos($fqn, '\\') + 1);

        return sprintf('on%s', $name);
    }

    /**
     * @param $eventName
     *
     * @return Dispatcher
     */
    protected function ensureKey($eventName)
    {
        isset($this->handlers[$eventName]) or $this->handlers[$eventName] = [];

        return $this;
    }
}