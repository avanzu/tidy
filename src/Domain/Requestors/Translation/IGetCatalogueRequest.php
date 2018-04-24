<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Requestors\Translation;

interface IGetCatalogueRequest
{
    /**
     * @param $id
     *
     * @return IGetCatalogueRequest
     */
    public function withId($id);

    public function id();
}