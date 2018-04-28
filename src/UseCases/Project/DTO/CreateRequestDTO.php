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
    protected $name;

    protected $description;

    protected $ownerId;

    /**
     * CreateRequestDTO constructor.
     *
     * @param $name
     * @param $description
     * @param $ownerId
     */
    public function __construct($name, $description, $ownerId)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->ownerId     = $ownerId;
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


}