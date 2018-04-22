<?php
/**
 * GetProjectCollectionRequestDTO.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\CollectionRequest;
use Tidy\Domain\Requestors\Project\IGetProjectCollectionRequest;

class GetProjectCollectionRequestDTO extends CollectionRequest implements IGetProjectCollectionRequest
{
    public $name;

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetProjectCollectionRequest
     */
    public function withName(Comparison $comparison = null)
    {
        $this->useComparison('name', $comparison);

        return $this;
    }


    /**
     * @param Comparison|null $comparison
     *
     * @return IGetProjectCollectionRequest
     */
    public function withDescription(Comparison $comparison = null)
    {
        $this->useComparison('description', $comparison);
        return $this;
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetProjectCollectionRequest
     */
    public function withCanonical(Comparison $comparison = null)
    {
        $this->useComparison('canonical', $comparison);
        return $this;
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetProjectCollectionRequest
     */
    public function withId(Comparison $comparison = null)
    {
        $this->useComparison('id', $comparison);
        return $this;
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return IGetProjectCollectionRequest
     */
    public function withOwner(Comparison $comparison = null) {
        $this->useComparison('owner', $comparison);
        return $this;
    }
}