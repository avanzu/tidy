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

    public function join($glue = PHP_EOL)
    {
        return implode($glue, $this->getArrayCopy());
    }

    public function list($bullet = '*')
    {
        return implode(
            PHP_EOL,
            array_map(
                function ($value) use ($bullet) { return sprintf("%s %s", $bullet, $value); },
                $this->getArrayCopy()
            )
        );
    }
}