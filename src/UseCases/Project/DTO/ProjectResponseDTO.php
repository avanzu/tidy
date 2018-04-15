<?php
/**
 * ProjectResponseDTO.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;


use Tidy\Responders\Project\IProjectResponse;
use Tidy\Responders\User\IUserExcerpt;
use Tidy\UseCases\User\DTO\UserExcerptDTO;

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
     * @var IUserExcerpt
     */
    public $owner;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @return IUserExcerpt
     */
    public function getOwner()
    {
        return $this->owner;
    }


}