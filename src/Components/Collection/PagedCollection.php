<?php
/**
 * PagedCollection.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\Components\Collection;


use ArrayIterator;
use Tidy\Requestors\ICollectionRequest;

class PagedCollection implements ICollection, IPagedCollection
{
    /**
     * @var int
     */
    protected $total;
    /**
     * @var int
     */
    protected $page;
    /**
     * @var array
     */
    protected $items = [];
    /**
     * @var int
     */
    protected $pageSize;
    /**
     * @var int
     */
    protected $pagesTotal;

    /**
     * PagedCollection constructor.
     *
     * @param array $items
     * @param null  $total
     * @param int   $page
     * @param int   $pageSize
     */
    public function __construct(
        array $items = [],
        $total = null,
        $page = ICollectionRequest::DEFAULT_PAGE,
        $pageSize = ICollectionRequest::DEFAULT_PAGE_SIZE
    ) {
        $this->items = $items;
        $this->evaluateTotal($items, $total)
             ->evaluatePageSize($items, $pageSize)
             ->calculatePagesTotal()
             ->calculatePage($page)
        ;

    }

    /**
     * @param $page
     *
     * @return IPagedCollection
     */
    private function calculatePage($page)
    {
        $this->page = min($this->pagesTotal, $page);

        return $this;
    }

    /**
     * @return IPagedCollection
     */
    private function calculatePagesTotal()
    {
        $pages            = (ceil($this->total / $this->pageSize) | 0);
        $this->pagesTotal = max($pages, 1);

        return $this;
    }

    /**
     * @param array $items
     * @param       $pageSize
     *
     * @return IPagedCollection
     */
    private function evaluatePageSize(array $items, $pageSize)
    {
        $this->pageSize = max(count($items), $pageSize);

        return $this;
    }

    /**
     * @param array $items
     * @param       $total
     *
     * @return IPagedCollection
     */
    private function evaluateTotal(array $items, $total)
    {
        $this->total = is_int($total) ? $total : count($items);

        return $this;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getPagesTotal()
    {
        return $this->pagesTotal;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function count()
    {
        return count($this->items);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function map($callback)
    {
        return array_map($callback, $this->items);
    }
}