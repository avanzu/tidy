<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Components\Collection;

class ObjectMap implements \Countable
{
    /**
     * @var \ArrayObject
     */
    protected $items;


    /**
     * ObjectMap constructor.
     */
    public function __construct() {
        $this->items = new \ArrayObject();
    }

    public function contains($key)
    {
        if( $this->items->offsetExists($key) ){
            return !is_null($this->items->offsetGet($key));
        }
        return false;
    }

    public function attach($key, $object)
    {
        $this->items->offsetSet($key, $object);
    }

    public function reveal($key)
    {
        return $this->items->offsetGet($key);
    }

    public function count()
    {
        return count($this->items);
    }


}