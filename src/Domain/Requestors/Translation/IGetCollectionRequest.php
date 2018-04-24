<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Requestors\Translation;

use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\ICollectionRequest;

interface IGetCollectionRequest extends ICollectionRequest
{
    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withName(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withSourceLanguage(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withTargetLanguage(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withSourceCulture(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withTargetCulture(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withId(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withCanonical(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withProject(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withSourceString(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withLocaleString(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withToken(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetCollectionRequest
     */
    public function withState(Comparison $comparison = null);
}