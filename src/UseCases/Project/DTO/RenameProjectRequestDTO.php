<?php
/**
 * This file is part of the Tidy Project.
 *
 * RenameProjectRequestDTO.php Created by avanzu on 22.04.18 with PhpStorm.
 *
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Domain\Requestors\Project\IRenameProjectRequest;

class RenameProjectRequestDTO implements IRenameProjectRequest
{
    public $projectId;

    public $name;

    public $description;

    public static function make()
    {
        return new self();
    }

    /**
     * @param $id
     *
     * @return IRenameProjectRequest
     */
    public function withProjectId($id)
    {
        $this->projectId = $id;

        return $this;
    }

    /**
     * @param $name
     *
     * @return IRenameProjectRequest
     */
    public function renameTo($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $description
     *
     * @return IRenameProjectRequest
     */
    public function describeAs($description)
    {
        $this->description = $description;
        return $this;
    }

    public function projectId()
    {
        return $this->projectId;
    }

    public function name()
    {
        return $this->name;
    }

    public function description()
    {
        return $this->description;
    }


}