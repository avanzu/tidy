<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Domain\Responders\Audit;

class ChangeResponse implements IChangeResponse
{

    public $changes = [];

    public function changes()
    {
        return $this->changes;
    }

    public function count()
    {
        return count($this->changes);
    }


}