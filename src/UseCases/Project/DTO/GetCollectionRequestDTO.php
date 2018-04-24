<?php
/**
 * GetCollectionRequestDTO.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\CollectionRequest;
use Tidy\Domain\Requestors\Project\IGetCollectionRequest;

class GetCollectionRequestDTO extends CollectionRequest implements IGetCollectionRequest
{
    public $name;

    /**
     * CollectionRequest constructor.
     *
     * @param int $page
     * @param int $pageSize
     */
    public function __construct(
        $page = CollectionRequest::DEFAULT_PAGE,
        $pageSize = CollectionRequest::DEFAULT_PAGE_SIZE
    ) {
        $this->page     = $page;
        $this->pageSize = $pageSize;
    }

    /**
     * @param int $page
     * @param int $pageSize
     *
     * @return static
     */
    public static function make(
        $page = CollectionRequest::DEFAULT_PAGE,
        $pageSize = CollectionRequest::DEFAULT_PAGE_SIZE
    ) {
        return new static($page, $pageSize);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withCanonical(Comparison $comparison = null)
    {
        $this->useComparison('canonical', $comparison);

        return $this;
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withDescription(Comparison $comparison = null)
    {
        $this->useComparison('description', $comparison);

        return $this;
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withId(Comparison $comparison = null)
    {
        $this->useComparison('id', $comparison);

        return $this;
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withName(Comparison $comparison = null)
    {
        $this->useComparison('name', $comparison);

        return $this;
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withOwner(Comparison $comparison = null)
    {
        $this->useComparison('owner', $comparison);

        return $this;
    }
}