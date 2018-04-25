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
    protected $catalogueId;

    protected $token;

    protected $localeString;

    protected $state;

    /**
     * TranslateRequestDTO constructor.
     *
     * @param $catalogueId
     * @param $token
     * @param $localeString
     * @param $state
     */
    public function __construct($catalogueId, $token, $localeString, $state = null)
    {
        $this->catalogueId  = $catalogueId;
        $this->token        = $token;
        $this->localeString = $localeString;
        $this->state        = $state;
    }


    public function catalogueId()
    {
        return $this->catalogueId;
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


}