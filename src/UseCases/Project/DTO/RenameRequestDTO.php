<?php
/**
 * This file is part of the Tidy Project.
 *
 * RenameRequestDTO.php Created by avanzu on 22.04.18 with PhpStorm.
 *
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Domain\Requestors\Project\IRenameRequest;

class RenameRequestDTO implements IRenameRequest
{
    protected $projectId;

    protected $name;

    protected $description;

    /**
     * RenameRequestDTO constructor.
     *
     * @param $projectId
     * @param $name
     * @param $description
     */
    public function __construct($projectId, $name, $description)
    {
        $this->projectId   = $projectId;
        $this->name        = $name;
        $this->description = $description;
    }


    public function description()
    {
        return $this->description;
    }

    public function name()
    {
        return $this->name;
    }

    public function projectId()
    {
        return $this->projectId;
    }




}