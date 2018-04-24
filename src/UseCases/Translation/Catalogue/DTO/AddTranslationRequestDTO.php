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

    /**
     * @param $ID
     *
     * @return \Tidy\Domain\Requestors\Translation\Catalogue\IAddTranslationRequest
     */
    public function withCatalogueId($ID)
    {
        $this->catalogueId = $ID;

        return $this;
    }

    /**
     * @param $string
     *
     * @return \Tidy\Domain\Requestors\Translation\Catalogue\IAddTranslationRequest
     */
    public function withLocaleString($string)
    {
        $this->localeString = $string;

        return $this;
    }

    /**
     * @param $string
     *
     * @return IAddTranslationRequest
     */
    public function withMeaning($string)
    {
        $this->meaning = $string;

        return $this;
    }

    /**
     * @param $string
     *
     * @return IAddTranslationRequest
     */
    public function withNotes($string)
    {
        $this->notes = $string;

        return $this;
    }

    /**
     * @param $string
     *
     * @return IAddTranslationRequest
     */
    public function withSourceString($string)
    {
        $this->sourceString = $string;

        return $this;
    }

    /**
     * @param $state
     *
     * @return IAddTranslationRequest
     */
    public function withState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @param $token
     *
     * @return \Tidy\Domain\Requestors\Translation\Catalogue\IAddTranslationRequest
     */
    public function withToken($token)
    {
        $this->token = $token;

        return $this;
    }
}