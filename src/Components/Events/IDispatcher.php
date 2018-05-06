<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 06.05.18
 *
 */

namespace Tidy\Components\Events;

interface IDispatcher
{
    public function broadcast(IEvent $event);
}