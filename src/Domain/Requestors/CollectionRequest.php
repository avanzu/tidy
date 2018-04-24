<?php
/**
 * CollectionRequest.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\Domain\Requestors;


use Tidy\Components\Collection\Boundary;
use Tidy\Components\DataAccess\Comparison;

abstract class CollectionRequest implements ICollectionRequest
{
    /**
     * @var int
     */
    public $page;
    /**
     * @var int
     */
    public $pageSize;


    public $criteria = [];

    /**
     * CollectionRequest constructor.
     *
     * @param int $page
     * @param int $pageSize
     */
    public function __construct($page = CollectionRequest::DEFAULT_PAGE, $pageSize = CollectionRequest::DEFAULT_PAGE_SIZE)
    {
        $this->page     = $page;
        $this->pageSize = $pageSize;
    }

    /**
     * @param int $page
     * @param int $pageSize
     *
     * @return static
     */
    public static function make($page = CollectionRequest::DEFAULT_PAGE, $pageSize = CollectionRequest::DEFAULT_PAGE_SIZE)
    {
        return new static($page, $pageSize);
    }

    /**
     * @return int
     */
    public function page()
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

    public function fromPage($page)
    {
        $this->page = $page;

        return $this;
    }

    public function withPageSize($pageSize)
    {
        $this->pageSize = $pageSize;

        return $this;
    }

    public function criteria()
    {
        return array_filter($this->criteria);
    }

    protected function useComparison($name, Comparison $comparison)
    {
        $this->criteria[$name] = $comparison;
        return $this;
    }

    public function boundary()
    {
        return new Boundary($this->page, $this->pageSize);
    }


}