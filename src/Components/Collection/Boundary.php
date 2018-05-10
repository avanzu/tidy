<?php
/**
 * Boundary.php
 * Tidy
 * Date: 22.04.18
 */

namespace Tidy\Components\Collection;

class Boundary
{

    const DEFAULT_PAGE      = 1;
    const DEFAULT_PAGE_SIZE = 20;

    /**
     * @var int
     */
    public $page = self::DEFAULT_PAGE;

    /**
     * @var int
     */
    public $pageSize = self::DEFAULT_PAGE_SIZE;

    /**
     * Boundary constructor.
     *
     * @param int $page
     * @param int $pageSize
     */
    public function __construct(int $page = self::DEFAULT_PAGE, int $pageSize = self::DEFAULT_PAGE_SIZE)
    {
        $this->page     = $page;
        $this->pageSize = $pageSize;
    }

    public function offset() {
        return (max(0, $this->page -1)  * $this->pageSize);
    }


}