<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 07.05.18
 *
 */

namespace Tidy\Domain\Events\Translation;

use Tidy\Components\Events\Event as DomainEvent;

abstract class Event extends DomainEvent
{
    protected $id;

    /**
     * Event constructor.
     *
     * @param $id
     */
    public function __construct($id) { $this->id = $id; }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }


}