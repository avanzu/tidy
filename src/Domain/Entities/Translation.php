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

    protected $sourceString;

    protected $localeString;

    protected $meaning;

    protected $notes;

    protected $state;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSourceString()
    {
        return $this->sourceString;
    }

    /**
     * @param mixed $sourceString
     *
     * @return $this
     */
    public function setSourceString($sourceString)
    {
        $this->sourceString = $sourceString;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocaleString()
    {
        return $this->localeString;
    }

    /**
     * @param mixed $localeString
     *
     * @return $this
     */
    public function setLocaleString($localeString)
    {
        $this->localeString = $localeString;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMeaning()
    {
        return $this->meaning;
    }

    /**
     * @param mixed $meaning
     *
     * @return $this
     */
    public function setMeaning($meaning)
    {
        $this->meaning = $meaning;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     *
     * @return $this
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }


}