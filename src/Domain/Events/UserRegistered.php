<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 06.05.18
 *
 */

namespace Tidy\Domain\Events;

use Tidy\Components\Events\Event;

class UserRegistered extends Event
{

    private $id;

    /**
     * UserRegistered constructor.
     *
     * @param string $id ;
     *
     */
    public function __construct($id)
    {

        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }

}