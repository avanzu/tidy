<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

class AddTranslationRequestDTO
{
    public $sourceString;

    public $localeString;

    public $catalogueId;

    public $meaning;

    public $notes;

    public $state;

    public $token;

    public static function make()
    {
        return new self();
    }

    /**
     * @param $string
     *
     * @return AddTranslationRequestDTO
     */
    public function withSourceString($string)
    {
        $this->sourceString = $string;

        return $this;
    }

    /**
     * @param $string
     *
     * @return AddTranslationRequestDTO
     */
    public function withLocaleString($string)
    {
        $this->localeString = $string;

        return $this;
    }

    /**
     * @param $ID
     *
     * @return AddTranslationRequestDTO
     */
    public function withCatalogueId($ID)
    {
        $this->catalogueId = $ID;

        return $this;
    }

    /**
     * @param $string
     *
     * @return AddTranslationRequestDTO
     */
    public function withMeaning($string)
    {
        $this->meaning = $string;

        return $this;
    }

    /**
     * @param $string
     *
     * @return AddTranslationRequestDTO
     */
    public function withNotes($string)
    {
        $this->notes = $string;

        return $this;
    }

    /**
     * @param $state
     *
     * @return AddTranslationRequestDTO
     */
    public function withState($state)
    {
        $this->state = $state;

        return $this;
    }

    public function catalogueId()
    {
        return $this->catalogueId;
    }

    public function sourceString()
    {
        return $this->sourceString;
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

    public function state()
    {
        return $this->state;
    }

    /**
     * @param $token
     *
     * @return AddTranslationRequestDTO
     */
    public function withToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function token()
    {
        return $this->token;
    }
}