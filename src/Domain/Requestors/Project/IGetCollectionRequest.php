<?php
/**
 * IGetCollectionRequest.php
 * Tidy
 * Date: 22.04.18
 */
namespace Tidy\Domain\Requestors\Project;

use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\ICollectionRequest as Request;

interface IGetCollectionRequest extends Request
{
    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withName(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withDescription(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withCanonical(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withId(Comparison $comparison = null);

    /**
     * @param Comparison|null $comparison
     *
     * @return $this
     */
    public function withOwner(Comparison $comparison = null);
}