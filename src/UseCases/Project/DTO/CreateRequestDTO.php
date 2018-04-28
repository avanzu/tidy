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

    protected $canonical;

    /**
     * CreateRequestDTO constructor.
     *
     * @param $name
     * @param $description
     * @param $ownerId
     * @param $canonical
     */
    public function __construct($name, $description, $ownerId, $canonical)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->ownerId     = $ownerId;
        $this->canonical   = $canonical;
    }

    public function canonical()
    {
        return $this->canonical;
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

    public function assignCanonical($canonical)
    {
        $this->canonical = $canonical;
    }


}