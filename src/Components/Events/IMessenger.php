<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 06.05.18
 *
 */

namespace Tidy\Components\Events;

interface IMessenger
{
    /**
     * @return IEvent[]
     */
    public function events();

    /**
     * @param IEvent $event
     *
     * @return void
     */
    public function queueEvent(IEvent $event);
}