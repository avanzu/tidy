<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\Translation\Message\DTO;

class TranslateRequestBuilder
{

    protected $catalogueId;

    protected $token;

    protected $localeString;

    protected $state;


    /**
     * @param $string
     *
     * @return $this
     */
    public function commitStateTo($string)
    {
        $this->state = $string;

        return $this;
    }
    /**
     * @param $localeString
     *
     * @return $this
     */
    public function translateAs($localeString)
    {
        $this->localeString = $localeString;

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function withCatalogueId($id)
    {
        $this->catalogueId = $id;

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
        return new TranslateRequestDTO($this->catalogueId, $this->token, $this->localeString, $this->state);
    }
}