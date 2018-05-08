<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 06.05.18
 *
 */

namespace Tidy\Components\Events;

use SplQueue as Queue;

trait TMessenger
{
    /**
     * @var Queue
     */
    protected $eventQueue;

    /**
     * @return Queue|IEvent[]
     */
    public function events()
    {
        return $this->eventQueue();
    }

    /**
     *
     */
    public function clearEvents() {
        $this->eventQueue = null;
    }

    /**
     * @param IEvent $event
     */
    protected function queueEvent(IEvent $event)
    {
        $this->eventQueue()->enqueue($event);
    }

    /**
     * @return Queue
     */
    protected function eventQueue()
    {
        if (!$this->eventQueue) {
            $this->eventQueue = new Queue();
        }

        return $this->eventQueue;
    }

}