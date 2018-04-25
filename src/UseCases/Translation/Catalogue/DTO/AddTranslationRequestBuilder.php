<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

class AddTranslationRequestBuilder
{

    protected $sourceString;

    protected $localeString;

    protected $catalogueId;

    protected $meaning;

    protected $notes;

    protected $state;

    protected $token;


    /**
     * @param $ID
     *
     * @return $this
     */
    public function withCatalogueId($ID)
    {
        $this->catalogueId = $ID;

        return $this;
    }

    /**
     * @param $string
     *
     * @return $this
     */
    public function withLocaleString($string)
    {
        $this->localeString = $string;

        return $this;
    }

    /**
     * @param $string
     *
     * @return $this
     */
    public function withMeaning($string)
    {
        $this->meaning = $string;

        return $this;
    }

    /**
     * @param $string
     *
     * @return $this
     */
    public function withNotes($string)
    {
        $this->notes = $string;

        return $this;
    }

    /**
     * @param $string
     *
     * @return $this
     */
    public function withSourceString($string)
    {
        $this->sourceString = $string;

        return $this;
    }

    /**
     * @param $state
     *
     * @return $this
     */
    public function withState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @param $token
     *
     * @return $this
     */
    public function withToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function build()
    {
        return new AddTranslationRequestDTO(
            $this->catalogueId,
            $this->token,
            $this->sourceString,
            $this->localeString,
            $this->state,
            $this->meaning,
            $this->notes
        );
    }
}