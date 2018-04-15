<?php
/**
 * ProjectResponseDTO.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;


use Tidy\Domain\Responders\AccessControl\IOwnerExcerpt;
use Tidy\Domain\Responders\Project\IProjectResponse;

/**
 * Class ProjectResponseDTO
 */
class ProjectResponseDTO implements IProjectResponse
{

    /**
     * @var string
     */
    public $name;
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $description;
    /**
     * @var string
     */
    public $canonical;
    /**
     * @var IOwnerExcerpt
     */
    public $owner;

    /**
     * @return string
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return IOwnerExcerpt
     */
    public function getOwner()
    {
        return $this->owner;
    }


}