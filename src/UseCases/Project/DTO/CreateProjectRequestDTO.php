<?php
/**
 * CreateProjectRequestDTO.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;


use Tidy\Requestors\Project\ICreateProjectRequest;

class CreateProjectRequestDTO implements ICreateProjectRequest
{
    public $name;
    public $description;
    public $ownerId;

    /**
     * @return ICreateProjectRequest
     */
    public static function make()
    {
        return new static;
    }

    /**
     * @param $name
     *
     * @return ICreateProjectRequest
     */
    public function withName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $description
     *
     * @return ICreateProjectRequest
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
     * @return ICreateProjectRequest
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