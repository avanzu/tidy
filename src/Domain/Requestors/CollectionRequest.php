<?php
/**
 * CollectionRequest.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\Domain\Requestors;


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
}