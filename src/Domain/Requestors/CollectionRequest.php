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
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize()
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

    public function getCriteria()
    {
        return array_filter($this->criteria);
    }

    protected function useComparison($name, Comparison $comparison)
    {
        $this->criteria[$name] = $comparison;
    }

    public function getBoundary()
    {
        return new Boundary($this->page, $this->pageSize);
    }


}