<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Components\Events;

interface IEventHandler
{
    /**
     * @param IEvent $event
     *
     * @return boolean
     */
    public function supports(IEvent $event);

    /**
     * @param IEvent $event
     *
     * @return void
     */
    public function handle(IEvent $event);

    /** @return int */
    public function priority();
}