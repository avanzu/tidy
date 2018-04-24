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
    public $projectId;

    /**
     * @return ILookUpRequest
     */
    public static function make()
    {
        return new self;
    }

    /**
     * @return int
     */
    public function projectId()
    {
        return $this->projectId;
    }

    /**
     * @param $id
     *
     * @return ILookUpRequest
     */
    public function withProjectId($id)
    {
        $this->projectId = $id;

        return $this;
    }
}