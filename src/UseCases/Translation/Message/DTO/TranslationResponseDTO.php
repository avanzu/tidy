<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\Message\DTO;

use Tidy\Domain\Responders\Translation\Message\ITranslationResponse;

class TranslationResponseDTO implements ITranslationResponse
{

    public    $id;

    public    $sourceString;

    public    $localeString;

    public    $meaning;

    public    $notes;

    public    $state;

    public $token;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLocaleString()
    {
        return $this->localeString;
    }

    /**
     * @return mixed
     */
    public function getMeaning()
    {
        return $this->meaning;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    public function getSourceString()
    {
        return $this->sourceString;
    }

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
    public function getToken()
    {
        return $this->token;
    }

}