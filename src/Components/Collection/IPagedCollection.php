<?php
/**
 * IPagedCollection.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\Components\Collection;

interface IPagedCollection extends ICollection
{
    /**
     * @return int
     */
    public function getPageSize();

    /**
     * @return int
     */
    public function getPage();

    /**
     * @return int
     */
    public function getPagesTotal();

    /**
     * @return int
     */
    public function getTotal();

}