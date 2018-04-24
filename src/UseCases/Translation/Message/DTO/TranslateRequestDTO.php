<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\Message\DTO;

use Tidy\Domain\Requestors\Translation\Message\ITranslateRequest;

class TranslateRequestDTO implements ITranslateRequest
{
    public $catalogueId;

    public $token;

    public $localeString;

    public $state;

    public static function make()
    {
        return new static;
    }

    public function catalogueId()
    {
        return $this->catalogueId;
    }

    /**
     * @param $string
     *
     * @return ITranslateRequest
     */
    public function commitStateTo($string)
    {
        $this->state = $string;

        return $this;
    }

    public function localeString()
    {
        return $this->localeString;
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
     * @param $localeString
     *
     * @return \Tidy\Domain\Requestors\Translation\Message\ITranslateRequest
     */
    public function translateAs($localeString)
    {
        $this->localeString = $localeString;

        return $this;
    }

    /**
     * @param $id
     *
     * @return \Tidy\Domain\Requestors\Translation\Message\ITranslateRequest
     */
    public function withCatalogueId($id)
    {
        $this->catalogueId = $id;

        return $this;
    }

    /**
     * @param $token
     *
     * @return ITranslateRequest
     */
    public function withToken($token)
    {
        $this->token = $token;

        return $this;
    }
}