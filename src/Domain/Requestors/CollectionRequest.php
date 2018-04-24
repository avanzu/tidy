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

    public function boundary()
    {
        return new Boundary($this->page, $this->pageSize);
    }

    public function criteria()
    {
        return array_filter($this->criteria);
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

    protected function useComparison($name, Comparison $comparison)
    {
        $this->criteria[$name] = $comparison;

        return $this;
    }


}