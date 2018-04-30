<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Components\Collection;

class HashMap extends \ArrayObject
{
    public function atIndex($index)
    {
        return $this->offsetExists($index) ? $this->offsetGet($index) : null;
    }
}