<?php
/**
 * LookUpRequestDTO.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Domain\Requestors\Project\ILookUpRequest;

class LookUpRequestDTO implements ILookUpRequest
{
    protected $projectId;

    /**
     * LookUpRequestDTO constructor.
     *
     * @param $projectId
     */
    public function __construct($projectId) { $this->projectId = $projectId; }


    /**
     * @return int
     */
    public function projectId()
    {
        return $this->projectId;
    }


}