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

    /**
     * @return Comparison[]
     */
    public function getCriteria()
    {
        // TODO: Implement getCriteria() method.
    }
}