<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

use Tidy\Domain\Responders\Translation\ITranslationResponse;

class TranslationResponseDTO implements ITranslationResponse
{

    public $id;

    public $sourceString;

    public $localeString;

    public $meaning;

    public $notes;

    public $state;

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @return mixed
     */
    public function getMeaning()
    {
        return $this->meaning;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSourceString()
    {
        return $this->sourceString;
    }

    /**
     * @return mixed
     */
    public function getLocaleString()
    {
        return $this->localeString;
    }


}