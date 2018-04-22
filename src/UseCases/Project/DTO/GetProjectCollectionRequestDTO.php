<?php
/**
 * GetProjectCollectionRequestDTO.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\CollectionRequest;

class GetProjectCollectionRequestDTO extends CollectionRequest
{
    public $name;

    /**
     * @param Comparison|null $comparison
     *
     * @return GetProjectCollectionRequestDTO
     */
    public function withName(Comparison $comparison = null)
    {
        $this->useComparison('name', $comparison);

        return $this;
    }


    /**
     * @param Comparison|null $comparison
     *
     * @return GetProjectCollectionRequestDTO
     */
    public function withDescription(Comparison $comparison = null)
    {
        $this->useComparison('description', $comparison);
        return $this;
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetProjectCollectionRequestDTO
     */
    public function withCanonical(Comparison $comparison = null)
    {
        $this->useComparison('canonical', $comparison);
        return $this;
    }

    /**
     * @param Comparison|null $comparison
     *
     * @return GetProjectCollectionRequestDTO
     */
    public function withId(Comparison $comparison = null)
    {
        $this->useComparison('id', $comparison);
        return $this;
    }
}