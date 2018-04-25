<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

use Tidy\Domain\Requestors\Translation\Catalogue\ILookUpRequest;

class LookUpRequestDTO implements ILookUpRequest
{
    protected $id;

    /**
     * LookUpRequestDTO constructor.
     *
     * @param $id
     */
    public function __construct($id) {
        $this->id = $id;
    }


    public function id()
    {
        return $this->id;
    }

}