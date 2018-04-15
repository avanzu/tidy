<?php
/**
 * ICollectionRequest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Requestors;


use Tidy\Components\DataAccess\Comparison;

interface ICollectionRequest
{
    const DEFAULT_PAGE      = 1;
    const DEFAULT_PAGE_SIZE = 20;

    /**
     * @return int
     */
    public function getPage();

    /**
     * @return int
     */
    public function getPageSize();

    /**
     * @return Comparison[]
     */
    public function getCriteria();
}