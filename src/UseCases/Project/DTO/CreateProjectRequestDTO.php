<?php
/**
 * CreateProjectRequestDTO.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;


class CreateProjectRequestDTO
{
    public $name;
    public $description;
    public $ownerId;

    /**
     * @return CreateProjectRequestDTO
     */
    public static function make()
    {
        return new static;
    }

    /**
     * @param $name
     *
     * @return CreateProjectRequestDTO
     */
    public function withName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $description
     *
     * @return CreateProjectRequestDTO
     */
    public function withDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $owner
     *
     * @return CreateProjectRequestDTO
     */
    public function withOwnerId($owner)
    {
        $this->ownerId = $owner;
        return $this;
    }

    public function getOwnerId() {
        return $this->ownerId;
    }

}