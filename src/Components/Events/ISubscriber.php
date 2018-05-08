<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Components\Events;

interface ISubscriber
{
    /**
     * Expected format:
     *
     * return [
     *  'event_name' => [callback, priority]
     * ];
     *
     * @return array
     */
    public function subscribeTo();
}