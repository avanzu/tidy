<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

class LookUpRequestBuilder
{
    protected $id;

    /**
     * @param $id
     *
     * @return $this
     */
    public function withId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function build()
    {
        return new LookUpRequestDTO($this->id);
    }
}