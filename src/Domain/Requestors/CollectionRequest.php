<?php
/**
 * CollectionRequest.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\Domain\Requestors;

use Tidy\Components\Collection\Boundary;
use Tidy\Components\DataAccess\Comparison;

class CollectionRequest implements ICollectionRequest
{
    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $pageSize;


    protected $criteria = [];

    /**
     * CollectionRequest constructor.
     *
     * @param int   $page
     * @param int   $pageSize
     * @param array $criteria
     */
    public function __construct(int $page, int $pageSize, array $criteria)
    {
        $this->page     = $page;
        $this->pageSize = $pageSize;
        $this->criteria = $criteria;
    }


    /**
     * @param $page
     *
     * @return $this
     * @deprecated
     */
    public function fromPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param $pageSize
     *
     * @return $this
     * @deprecated
     */
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