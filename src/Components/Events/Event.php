<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\Components\Events;

abstract class Event implements IEvent
{
    public static function handledBy()
    {
        $fqn  = static::class;
        $name = substr($fqn, strrpos($fqn, '\\')+1);
        return sprintf('on%s', $name);
    }


}