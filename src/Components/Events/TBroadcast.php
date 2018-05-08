<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Components\Events;

trait TBroadcast
{
    /**
     * @var IDispatcher
     */
    protected $dispatcher;

    protected function broadcast(IMessenger $messenger)
    {
        $queue = $messenger->events();
        foreach ($queue as $event) {
            $this->dispatcher->broadcast($event);
        }

        $messenger->clearEvents();
    }

}