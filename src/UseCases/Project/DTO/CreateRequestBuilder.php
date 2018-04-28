<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\UseCases\Project\DTO;

class CreateRequestBuilder
{

    protected $name;

    protected $description;

    protected $ownerId;

    /**
     * @param $description
     *
     * @return $this
     */
    public function withDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function withName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $owner
     *
     * @return $this
     */
    public function withOwnerId($owner)
    {
        $this->ownerId = $owner;

        return $this;
    }

    public function build()
    {
        return new CreateRequestDTO($this->name, $this->description, $this->ownerId);
    }
}