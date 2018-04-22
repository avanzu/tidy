<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Project\DTO;

class ExcerptDTO
{
    public $name;

    public $canonical;

    public $id;

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    public function getId()
    {
        return $this->id;
    }


}