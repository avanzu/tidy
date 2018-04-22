<?php
/**
 * This file is part of the Tidy Project.
 *
 * RenameRequestDTO.php Created by avanzu on 22.04.18 with PhpStorm.
 *
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Domain\Requestors\Project\IRenameRequest;

class RenameRequestDTO implements IRenameRequest
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
     * @return IRenameRequest
     */
    public function withProjectId($id)
    {
        $this->projectId = $id;

        return $this;
    }

    /**
     * @param $name
     *
     * @return IRenameRequest
     */
    public function renameTo($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $description
     *
     * @return IRenameRequest
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