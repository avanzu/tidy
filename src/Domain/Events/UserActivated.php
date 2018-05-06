<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 06.05.18
 *
 */

namespace Tidy\Domain\Events;

use Tidy\Components\Events\Event;
use Tidy\Domain\Entities\User;

class UserActivated extends Event
{
    /**
     * @var string
     */
    private   $id;

    /**
     * UserActivated constructor.
     *
     * @param $id
     */
    public function __construct($id) {
        $this->id = $id;
    }


    public function id() {
        return $this->id;
    }


}