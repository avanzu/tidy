<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\Domain\Events;

class Messenger implements \Countable
{
    protected $handlers = [];

    public function subscribe(...$handlers)
    {
        foreach ($handlers as $handler) {
            $this->handlers[spl_object_hash($handler)] = $handler;
        }
    }

    public function unsubscribe($handler)
    {
        $this->handlers = array_filter($this->handlers, function($candidate) use ($handler){
            return ! ($candidate === $handler);
        });
    }



    /**
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->handlers);
    }

    public function clear() {
        $this->handlers = [];
    }

    protected function getEventHandlerNameFor(IEvent $event)
    {
        $fqn  = get_class($event);
        $name = substr($fqn, strrpos($fqn, '\\')+1);
        return sprintf('on%s', $name);
    }

    public function broadcast(IEvent $event) {

        $handlerName = $this->getEventHandlerNameFor($event);
        foreach ($this->handlers as $handler) {
            if(! is_callable([$handler, $handlerName])) continue;
            call_user_func([$handler, $handlerName], $event);
        }

        return $event;

    }
}