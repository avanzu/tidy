<?php
/**
 * ProjectResponseDTO.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;


class ProjectResponseDTO
{

    public $name;
    public $id;
    public $description;

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }


}