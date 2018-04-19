<?php
/**
 * CollectionResponse.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\Domain\Responders;


abstract class CollectionResponse implements ICollectionResponse, \Countable
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


}