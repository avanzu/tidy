<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 06.05.18
 *
 */

namespace Tidy\Components\Events;

use SplQueue;

interface IMessenger
{
    /**
     * @return IEvent[]|SplQueue
     */
    public function events();

    /**
     * @return void
     */
    public function clearEvents();

}