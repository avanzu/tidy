<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\UseCases\Project\DTO;

class RenameRequestBuilder
{

    protected $projectId;

    protected $name;

    protected $description;

    /**
     * @param $description
     *
     * @return $this
     */
    public function describeAs($description)
    {
        $this->description = $description;

        return $this;
    }
    /**
     * @param $name
     *
     * @return $this
     */
    public function renameTo($name)
    {
        $this->name = $name;

        return $this;
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
     * @return RenameRequestDTO
     */
    public function build()
    {
        return new RenameRequestDTO($this->projectId, $this->name, $this->description);
    }
}