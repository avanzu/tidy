<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\CollectionRequest;
use Tidy\Domain\Requestors\Translation\IGetSubSetRequest;

class GetSubSetRequestDTO extends CollectionRequest implements IGetSubSetRequest
{
    public $catalogueId;

    /**
     * CollectionRequest constructor.
     *
     * @param     $catalogueId
     * @param int $page
     * @param int $pageSize
     */
    public function __construct(
        $catalogueId,
        $page = CollectionRequest::DEFAULT_PAGE,
        $pageSize = CollectionRequest::DEFAULT_PAGE_SIZE
    ) {
        $this->catalogueId = $catalogueId;
        $this->page        = $page;
        $this->pageSize    = $pageSize;
    }

    /**
     * @param     $catalogueId
     * @param int $page
     * @param int $pageSize
     *
     * @return IGetSubSetRequest
     */
    public static function make(
        $catalogueId,
        $page = CollectionRequest::DEFAULT_PAGE,
        $pageSize = CollectionRequest::DEFAULT_PAGE_SIZE
    ) {
        return new static($catalogueId, $page, $pageSize);
    }

    public function catalogueId()
    {
        return $this->catalogueId;
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withId(Comparison $comparison = null)
    {
        return $this->useComparison('id', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withToken(Comparison $comparison = null)
    {
        return $this->useComparison('token', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withSourceString(Comparison $comparison = null)
    {
        return $this->useComparison('sourceString', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withLocaleString(Comparison $comparison = null)
    {
        return $this->useComparison('localeString', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withState(Comparison $comparison = null)
    {
        return $this->useComparison('state', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withMeaning(Comparison $comparison = null)
    {
        return $this->useComparison('meaning', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withNotes(Comparison $comparison = null)
    {
        return $this->useComparison('notes', $comparison);
    }

}