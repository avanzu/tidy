<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Components\DependencyInjection;

use Tidy\Components\Collection\ObjectMap;

abstract class Container
{
    /**
     * @var ObjectMap
     */
    protected $instances;

    protected function instances() {
        if( ! $this->instances ) $this->instances = new ObjectMap();
        return $this->instances;
    }
    protected function contains($key)
    {
        return $this->instances()->contains($key);
    }

    protected function attach($key, $object) {
        $this->instances()->attach($key, $object);
    }

    protected function reveal($key)
    {
        return $this->instances()->reveal($key);
    }

}