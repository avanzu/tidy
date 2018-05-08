<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Components\Events;

use SplPriorityQueue;
use Tidy\Components\Exceptions\InvalidArgument;

/**
 * Class EventDispatcher
 */
class EventDispatcher implements IDispatcher
{

    /**
     * @var
     */
    protected $listeners;

    /**
     * @param IEvent $event
     */
    public function broadcast(IEvent $event)
    {
        $queue = clone $this->queue($event::NAME);
        $queue->setExtractFlags(SplPriorityQueue::EXTR_DATA);
        $queue->top();
        while($queue->valid()) {
            call_user_func($queue->current(), $event);
            $queue->next();
        }
    }

    /**
     * @param ISubscriber $subscriber
     */
    public function addSubscriber(ISubscriber $subscriber)
    {
        foreach ($subscriber->subscribeTo() as $eventName => $methodPriority) {
            list($methodName, $priority) = array_pad($methodPriority, 2, 0);
            $this->listenTo($eventName, $this->makeCallable($subscriber, $methodName), $priority);
        }
    }

    /**
     * @param     $eventName
     * @param     $listener
     * @param int $priority
     */
    public function listenTo($eventName, $listener, $priority = 0)
    {
        if (!is_callable($listener)) {
            throw new InvalidArgument(
                sprintf(
                    'Failed to add event listener for "%s". Expected callable got "%s".',
                    $eventName,
                    gettype($listener)
                )
            );
        }

        $this->queue($eventName)->insert($listener, $priority);
    }

    /**
     * @param $eventName
     *
     * @return SplPriorityQueue
     */
    public function listenersFor($eventName)
    {
        return $this->queue($eventName);
    }

    /**
     * @param $eventName
     * @param $listener
     */
    public function stopListening($eventName, $listener)
    {
        $newQueue = new SplPriorityQueue();
        $queue    = $this->queue($eventName);
        $queue->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
        while ($queue->valid()) {
            $entry = (object)$queue->extract();
            if (!($entry->data === $listener)) {
                $newQueue->insert($entry->data, $entry->priority);
            }
        }

        $this->listeners[$eventName] = $newQueue;
    }

    /**
     * @param ISubscriber $subscriber
     */
    public function removeSubscriber(ISubscriber $subscriber)
    {
        foreach ($subscriber->subscribeTo() as $eventName => $methodPriority) {
            list($methodName) = $methodPriority;
            $this->stopListening($eventName, $this->makeCallable($subscriber, $methodName));
        }
    }

    /**
     * @param $eventName
     *
     * @return SplPriorityQueue
     */
    protected function queue($eventName)
    {
        isset($this->listeners[$eventName]) or $this->listeners[$eventName] = new SplPriorityQueue();

        return $this->listeners[$eventName];
    }

    /**
     * @param ISubscriber $subscriber
     * @param             $methodName
     *
     * @return callable
     */
    private function makeCallable(ISubscriber $subscriber, $methodName)
    {
        return [$subscriber, $methodName];
    }
}