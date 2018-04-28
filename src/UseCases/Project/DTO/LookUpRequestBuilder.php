<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\UseCases\Project\DTO;

class LookUpRequestBuilder
{
    protected $projectId;

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

    public function build()
    {
        return new LookUpRequestDTO($this->projectId);
    }

}