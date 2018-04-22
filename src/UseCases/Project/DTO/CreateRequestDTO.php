<?php
/**
 * CreateRequestDTO.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;


use Tidy\Domain\Requestors\Project\ICreateRequest;

class CreateRequestDTO implements ICreateRequest
{
    public $name;
    public $description;
    public $ownerId;

    /**
     * @return ICreateRequest
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
     * @return ICreateRequest
     */
    public function withDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param $name
     *
     * @return ICreateRequest
     */
    public function withName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $owner
     *
     * @return ICreateRequest
     */
    public function withOwnerId($owner)
    {
        $this->ownerId = $owner;

        return $this;
    }

}