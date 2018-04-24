<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Requestors\Translation\Message;

use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\ICollectionRequest;

interface IGetSubSetRequest extends ICollectionRequest
{
    public function catalogueId();

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withId(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withToken(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withSourceString(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withLocaleString(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withState(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withMeaning(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetSubSetRequest
     */
    public function withNotes(Comparison $comparison = null);
}