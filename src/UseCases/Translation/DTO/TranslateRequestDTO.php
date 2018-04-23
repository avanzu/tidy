<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

class TranslateRequestDTO
{
    public $catalogueId;

    public $token;

    public $localeString;

    public $state;

    public static function make()
    {
        return new static;
    }

    /**
     * @param $id
     *
     * @return TranslateRequestDTO
     */
    public function withCatalogueId($id)
    {
        $this->catalogueId = $id;

        return $this;
    }

    /**
     * @param $token
     *
     * @return TranslateRequestDTO
     */
    public function withToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param $localeString
     *
     * @return TranslateRequestDTO
     */
    public function translateAs($localeString)
    {
        $this->localeString = $localeString;

        return $this;
    }

    /**
     * @param $string
     *
     * @return TranslateRequestDTO
     */
    public function commitStateTo($string)
    {
        $this->state = $string;

        return $this;
    }

    public function localeString() {
        return $this->localeString;
    }

    public function state() {
        return $this->state;
    }

    public function catalogueId() {
        return $this->catalogueId;
    }

    public function token() {
        return $this->token;
    }
}