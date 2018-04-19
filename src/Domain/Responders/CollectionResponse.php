<?php
/**
 * CollectionResponse.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\Domain\Responders;


use Tidy\Components\Collection\IPagedCollection;

abstract class CollectionResponse implements ICollectionResponse, \Countable
{
    /**
     * @var int
     */
    public $page;
    /**
     * @var int
     */
    public $pageSize;
    /**
     * @var int
     */
    public $pagesTotal;

    /**
     * @var int
     */
    public $itemsTotal;


    /**
     * @return int
     */
    public function currentPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function pageSize()
    {
        return $this->pageSize;
    }

    /**
     * @return int
     */
    public function total()
    {
        return $this->itemsTotal;
    }

    /**
     * @return int
     */
    public function pagesTotal()
    {
        return $this->pagesTotal;
    }

    public function pickBoundaries(IPagedCollection $collection)
    {
        $this->page       = $collection->getPage();
        $this->pageSize   = $collection->getPageSize();
        $this->itemsTotal = $collection->getTotal();
        $this->pagesTotal = $collection->getPagesTotal();
    }


}