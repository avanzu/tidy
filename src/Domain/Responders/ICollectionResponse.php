<?php
/**
 * ICollectionResponse.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\Domain\Responders;


use Tidy\Components\Collection\IPagedCollection;

interface ICollectionResponse
{
    /**
     * @return int
     */
    public function currentPage();

    /**
     * @return int
     */
    public function pageSize();

    /**
     * @return int
     */
    public function pagesTotal();

    /**
     * @return int
     */
    public function total();

    public function pickBoundaries(IPagedCollection $collection);
}