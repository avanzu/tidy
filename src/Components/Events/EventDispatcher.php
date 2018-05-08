<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Components\Events;

use SplObjectStorage;
use SplPriorityQueue;

/**
 * Class EventDispatcher
 */
class EventDispatcher implements IDispatcher, \Countable
{

    /**
     * @var SplObjectStorage|IEventHandler[]
     */
    protected $handlers;

    /**
     * EventDispatcher constructor.
     *
     * @param array $handlers
     */
    public function __construct(... $handlers)
    {
        $this->handlers = new SplObjectStorage();
        foreach ($handlers as $handler) $this->attach($handler);

    }


    /**
     * @param IEvent $event
     */
    public function broadcast(IEvent $event)
    {
        $this->execute($event, $this->enqueue($event));
    }

    /**
     * @param IEventHandler $handler
     */
    public function attach(IEventHandler $handler)
    {
        $this->handlers->attach($handler);
    }

    /**
     * @param IEventHandler $handler
     *
     * @return bool
     */
    public function contains(IEventHandler $handler)
    {
        return $this->handlers->contains($handler);
    }

    /**
     * @param $handler
     */
    public function detach($handler)
    {
        $this->handlers->detach($handler);
    }

    /** @inheritdoc */
    public function count()
    {
        return count($this->handlers);
    }

    /**
     * @param IEvent           $event
     * @param SplPriorityQueue $queue
     */
    private function execute(IEvent $event, SplPriorityQueue $queue)
    {
        while ($queue->valid()) {
            $queue->extract()->handle($event);
        }
    }

    /**
     * @param IEvent $event
     *
     * @return SplPriorityQueue
     */
    private function enqueue(IEvent $event)
    {
        $queue = new SplPriorityQueue();

        foreach ($this->handlers as $handler) {
            if ($handler->supports($event)) {
                $queue->insert($handler, $handler->priority());
            }
        }

        return $queue;
    }
}