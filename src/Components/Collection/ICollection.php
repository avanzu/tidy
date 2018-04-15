<?php
/**
 * ICollection.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\Components\Collection;


/**
 * Class PagedCollection
 */
interface ICollection extends \Countable, \IteratorAggregate
{
    /**
     * @return int
     */
    public function count();

    /**
     * @inheritdoc
     */
    public function getIterator();

    /**
     * @param $callback
     *
     * @return array
     */
    public function map($callback);
}