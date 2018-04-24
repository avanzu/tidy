<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

class GetCatalogueRequestDTO
{
    public $id;


    public static function make()
    {
        return new static;
    }

    /**
     * @param $id
     *
     * @return GetCatalogueRequestDTO
     */
    public function withId($id)
    {
        $this->id = $id;

        return $this;
    }


    public function id()
    {
        return $this->id;
    }
}