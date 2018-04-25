<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

use Tidy\Domain\Requestors\Translation\Catalogue\IAddTranslationRequest;

class AddTranslationRequestDTO implements IAddTranslationRequest
{
    protected $sourceString;

    protected $localeString;

    protected $catalogueId;

    protected $meaning;

    protected $notes;

    protected $state;

    protected $token;

    /**
     * AddTranslationRequestDTO constructor.
     *
     * @param $catalogueId
     * @param $token
     * @param $sourceString
     * @param $localeString
     * @param $state
     * @param $meaning
     * @param $notes
     */
    public function __construct($catalogueId, $token, $sourceString, $localeString, $state, $meaning, $notes)
    {
        $this->sourceString = $sourceString;
        $this->localeString = $localeString;
        $this->catalogueId  = $catalogueId;
        $this->meaning      = $meaning;
        $this->notes        = $notes;
        $this->state        = $state;
        $this->token        = $token;
    }


    public function catalogueId()
    {
        return $this->catalogueId;
    }

    public function localeString()
    {
        return $this->localeString;
    }

    public function meaning()
    {
        return $this->meaning;
    }

    public function notes()
    {
        return $this->notes;
    }

    public function sourceString()
    {
        return $this->sourceString;
    }

    public function state()
    {
        return $this->state;
    }

    public function token()
    {
        return $this->token;
    }

}