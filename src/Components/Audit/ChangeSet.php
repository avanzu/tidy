<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Components\Audit;

use Traversable;

class ChangeSet implements \Countable, \IteratorAggregate
{
    public $changes = [];

    /**
     * ChangeSet constructor.
     *
     * @param array $changes
     */
    public function __construct(array $changes = [])
    {
        foreach ($changes as $change) {
            $this->add($change);
        }
    }


    /**
     * @param mixed ...$changes
     *
     * @return static
     */
    public static function make(...$changes)
    {
        return new static($changes);
    }

    /**
     * @param Change $change
     *
     * @return ChangeSet
     */
    public function add(Change $change = null)
    {
        if (null !== $change) {
            $this->changes[] = $change;
        }

        return $this;
    }

    /**
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->changes);
    }

    /**
     * Retrieve an external iterator
     *
     * @link  http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->changes);
    }
}