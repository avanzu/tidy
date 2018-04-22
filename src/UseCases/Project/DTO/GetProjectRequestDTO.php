<?php
/**
 * GetProjectRequestDTO.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;


use Tidy\Domain\Requestors\Project\IGetProjectRequest;

class GetProjectRequestDTO implements IGetProjectRequest
{
    public $projectId;

    /**
     * @return IGetProjectRequest
     */
    public static function make()
    {
        return new self;
    }

    /**
     * @param $id
     *
     * @return IGetProjectRequest
     */
    public function withProjectId($id)
    {
        $this->projectId = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function projectId()
    {
        return $this->projectId;
    }
}