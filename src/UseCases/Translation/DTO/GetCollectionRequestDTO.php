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

class GetCollectionRequestDTO extends CollectionRequest
{

    /**
     * @param Comparison|null $comparison
     *
     * @return GetCollectionRequestDTO
     */
    public function withName(Comparison $comparison = null)
    {
        return $this->useComparison('name', $comparison);

    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetCollectionRequestDTO
     */
    public function withSourceLanguage(Comparison $comparison = null) {
        return $this->useComparison('sourceLanguage', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetCollectionRequestDTO
     */
    public function withTargetLanguage(Comparison $comparison = null) {
        return $this->useComparison('targetLanguage', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetCollectionRequestDTO
     */
    public function withSourceCulture(Comparison $comparison = null) {
        return $this->useComparison('sourceCulture', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetCollectionRequestDTO
     */
    public function withTargetCulture(Comparison $comparison = null) {
        return $this->useComparison('targetCulture', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetCollectionRequestDTO
     */
    public function withId(Comparison $comparison = null) {
        return $this->useComparison('id', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetCollectionRequestDTO
     */
    public function withCanonical(Comparison $comparison = null) {
        return $this->useComparison('canonical', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetCollectionRequestDTO
     */
    public function withProject(Comparison $comparison = null) {
        return $this->useComparison('project', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetCollectionRequestDTO
     */
    public function withSourceString(Comparison $comparison = null) {
        return $this->useComparison('sourceString', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetCollectionRequestDTO
     */
    public function withLocaleString(Comparison $comparison = null) {
        return $this->useComparison('localeString', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetCollectionRequestDTO
     */
    public function withToken(Comparison $comparison = null) {
        return $this->useComparison('token', $comparison);
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetCollectionRequestDTO
     */
    public function withState(Comparison $comparison = null) {
        return $this->useComparison('state', $comparison);
    }


}