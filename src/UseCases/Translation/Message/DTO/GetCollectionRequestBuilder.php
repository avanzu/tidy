<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\Translation\Message\DTO;

use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\CollectionRequestBuilder;

class GetCollectionRequestBuilder extends CollectionRequestBuilder
{

    protected $catalogueId;

    /**
     * GetCollectionRequestBuilder constructor.
     *
     * @param $catalogueId
     */
    public function __construct($catalogueId)
    {
        $this->catalogueId = $catalogueId;
    }


    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withId(Comparison $comparison = null)
    {
        return $this->useComparison('id', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withLocaleString(Comparison $comparison = null)
    {
        return $this->useComparison('localeString', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withMeaning(Comparison $comparison = null)
    {
        return $this->useComparison('meaning', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withNotes(Comparison $comparison = null)
    {
        return $this->useComparison('notes', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withSourceString(Comparison $comparison = null)
    {
        return $this->useComparison('sourceString', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withState(Comparison $comparison = null)
    {
        return $this->useComparison('state', $comparison);
    }

    public function build()
    {
        return new GetCollectionRequestDTO(
            $this->page,
            $this->pageSize,
            array_filter($this->criteria),
            $this->catalogueId
        );
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withToken(Comparison $comparison = null)
    {
        return $this->useComparison('token', $comparison);
    }


}