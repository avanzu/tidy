<?php
/**
 * This file is part of the Tidy Project.
 *
 * Translation.php Created by avanzu on 22.04.18 with PhpStorm.
 *
 */

namespace Tidy\Domain\Entities;

abstract class Translation
{
    protected $id;

    protected $token;

    protected $sourceString;

    protected $localeString;

    protected $meaning;

    protected $notes;

    protected $state;

    /**
     * Translation constructor.
     *
     * @param $token
     * @param $sourceString
     * @param $localeString
     * @param $meaning
     * @param $notes
     * @param $state
     */
    public function __construct($token, $sourceString, $localeString, $meaning, $notes, $state)
    {
        $this->token        = $token;
        $this->sourceString = $sourceString;
        $this->localeString = $localeString;
        $this->meaning      = $meaning;
        $this->notes        = $notes;
        $this->state        = $state;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
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


    public function isEqualTo($subject)
    {
        if (!($subject instanceof Translation)) {
            return false;
        }
        if (!($subject->getToken() === $this->getToken())) {
            return false;
        }

        return true;
    }

    public function __toString()
    {
        if (!empty($this->localeString)) {
            return $this->getLocaleString();
        }
        if (!empty($this->sourceString)) {
            return $this->getSourceString();
        }

        return $this->getToken();
    }


}