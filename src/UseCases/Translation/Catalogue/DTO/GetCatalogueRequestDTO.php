<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

use Tidy\Domain\Requestors\Translation\Catalogue\IGetCatalogueRequest;

class GetCatalogueRequestDTO implements IGetCatalogueRequest
{
    public $id;


    public static function make()
    {
        return new static;
    }

    public function id()
    {
        return $this->id;
    }

    /**
     * @param $id
     *
     * @return IGetCatalogueRequest
     */
    public function withId($id)
    {
        $this->id = $id;

        return $this;
    }
}