<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Domain\Responders\Project\IExcerpt;

class ExcerptDTO implements IExcerpt
{
    public $name;

    public $canonical;

    public $id;

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

    public function getName()
    {
        return $this->name;
    }


}