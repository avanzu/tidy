<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 06.05.18
 *
 */

namespace Tidy\Components\Events;

trait TMessenger
{
    /**
     * @var \SplQueue
     */
    protected $eventQueue;

    protected function eventQueue()
    {
        if( ! $this->eventQueue ) $this->eventQueue = new \SplQueue();
        return $this->eventQueue;
    }
    public function events() {
        return $this->eventQueue();
    }

    public function queueEvent(IEvent $event)
    {
        $this->eventQueue()->enqueue($event);
    }

}