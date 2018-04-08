<?php
/**
 * CollectionResponse.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\Responders;


abstract  class CollectionResponse implements ICollectionResponse
{
    /**
     * @var
     */
    public $page;
    /**
     * @var
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

    /**
     * @return int
     */
    public function getTotal()
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
}