<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\CollectionRequestBuilder;

class GetCollectionRequestBuilder extends CollectionRequestBuilder
{


    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withCanonical(Comparison $comparison = null)
    {
        return $this->useComparison('canonical', $comparison);
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
    public function withName(Comparison $comparison = null)
    {
        return $this->useComparison('name', $comparison);

    }

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withProject(Comparison $comparison = null)
    {
        return $this->useComparison('project', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withSourceCulture(Comparison $comparison = null)
    {
        return $this->useComparison('sourceCulture', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withSourceLanguage(Comparison $comparison = null)
    {
        return $this->useComparison('sourceLanguage', $comparison);
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

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withTargetCulture(Comparison $comparison = null)
    {
        return $this->useComparison('targetCulture', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withTargetLanguage(Comparison $comparison = null)
    {
        return $this->useComparison('targetLanguage', $comparison);
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