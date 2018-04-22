<?php
/**
 * CreateProjectRequestDTO.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;


use Tidy\Domain\Requestors\Project\ICreateProjectRequest;

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
     * @return mixed
     */
    public function description()
    {
        return $this->description;
    }

    public function name()
    {
        return $this->name;
    }

    public function ownerId()
    {
        return $this->ownerId;
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
     * @param $owner
     *
     * @return ICreateProjectRequest
     */
    public function withOwnerId($owner)
    {
        $this->ownerId = $owner;

        return $this;
    }

}