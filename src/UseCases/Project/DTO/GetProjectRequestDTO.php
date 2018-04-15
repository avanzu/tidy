<?php
/**
 * GetProjectRequestDTO.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;


class GetProjectRequestDTO
{
    public $projectId;

    /**
     * @return GetProjectRequestDTO
     */
    public static function make()
    {
        return new self;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function withProjectId($id)
    {
        $this->projectId = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getProjectId()
    {
        return $this->projectId;
    }
}