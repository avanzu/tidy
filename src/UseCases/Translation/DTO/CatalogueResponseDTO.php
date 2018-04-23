<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

class CatalogueResponseDTO implements \Countable
{
    public $name;

    public $canonical;

    public $id;

    public $sourceLanguage;

    public $sourceCulture;

    public $targetLanguage;

    public $targetCulture;

    public $project;

    public $translations = [];

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCanonical()
    {
        return $this->canonical;
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
    public function getSourceLanguage()
    {
        return $this->sourceLanguage;
    }

    /**
     * @return mixed
     */
    public function getSourceCulture()
    {
        return $this->sourceCulture;
    }

    /**
     * @return mixed
     */
    public function getTargetLanguage()
    {
        return $this->targetLanguage;
    }

    /**
     * @return mixed
     */
    public function getTargetCulture()
    {
        return $this->targetCulture;
    }

    /**
     * @return Excerpt
     */
    public function getProject()
    {
        return $this->project;
    }


    /**
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->translations);
    }

    public function contains($token)
    {
        return isset($this->translations[$token]);
    }
}