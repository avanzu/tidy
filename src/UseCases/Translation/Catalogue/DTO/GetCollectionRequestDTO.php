<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\CollectionRequest;
use Tidy\Domain\Requestors\Translation\Catalogue\IGetCollectionRequest;

class GetCollectionRequestDTO extends CollectionRequest implements IGetCollectionRequest
{

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
     * @return IGetCollectionRequest
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
        return $this->useComparison('canonical', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withId(Comparison $comparison = null)
    {
        return $this->useComparison('id', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withLocaleString(Comparison $comparison = null)
    {
        return $this->useComparison('localeString', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withName(Comparison $comparison = null)
    {
        return $this->useComparison('name', $comparison);

    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withProject(Comparison $comparison = null)
    {
        return $this->useComparison('project', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withSourceCulture(Comparison $comparison = null)
    {
        return $this->useComparison('sourceCulture', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withSourceLanguage(Comparison $comparison = null)
    {
        return $this->useComparison('sourceLanguage', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withSourceString(Comparison $comparison = null)
    {
        return $this->useComparison('sourceString', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withState(Comparison $comparison = null)
    {
        return $this->useComparison('state', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withTargetCulture(Comparison $comparison = null)
    {
        return $this->useComparison('targetCulture', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withTargetLanguage(Comparison $comparison = null)
    {
        return $this->useComparison('targetLanguage', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withToken(Comparison $comparison = null)
    {
        return $this->useComparison('token', $comparison);
    }


}