<?php
/**
 * ICollectionRequest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Requestors;


use Tidy\Components\Collection\Boundary;
use Tidy\Components\DataAccess\Comparison;

interface ICollectionRequest
{
    const DEFAULT_PAGE      = 1;
    const DEFAULT_PAGE_SIZE = 20;

    /**
     * @return int
     */
    public function page();

    /**
     * @return int
     */
    public function pageSize();

    /**
     * @return Comparison[]
     */
    public function criteria();

    /**
     * @return Boundary
     */
    public function boundary();
}