<?php
/**
 * This file is part of the Tidy Project.
 *
 * TranslationCatalogue.php Created by avanzu on 22.04.18 with PhpStorm.
 *
 */

namespace Tidy\Domain\Entities;

abstract class TranslationCatalogue
{
    protected $sourceLanguage;

    protected $sourceCulture;

    protected $targetLanguage;

    protected $targetCulture;

    protected $name;

    protected $id;

    protected $canonical;

    protected $translations = [];

    /**
     * @return mixed
     */
    public function getSourceLanguage()
    {
        return $this->sourceLanguage;
    }

    /**
     * @param mixed $sourceLanguage
     *
     * @return $this
     */
    public function setSourceLanguage($sourceLanguage)
    {
        $this->sourceLanguage = $sourceLanguage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSourceCulture()
    {
        return $this->sourceCulture;
    }

    /**
     * @param mixed $sourceCulture
     *
     * @return $this
     */
    public function setSourceCulture($sourceCulture)
    {
        $this->sourceCulture = $sourceCulture;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTargetLanguage()
    {
        return $this->targetLanguage;
    }

    /**
     * @param mixed $targetLanguage
     *
     * @return $this
     */
    public function setTargetLanguage($targetLanguage)
    {
        $this->targetLanguage = $targetLanguage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTargetCulture()
    {
        return $this->targetCulture;
    }

    /**
     * @param mixed $targetCulture
     *
     * @return $this
     */
    public function setTargetCulture($targetCulture)
    {
        $this->targetCulture = $targetCulture;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

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
     * @return array
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }

    /**
     * @param array $translations
     *
     * @return $this
     */
    public function setTranslations($translations)
    {
        $this->translations = $translations;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @param mixed $canonical
     *
     * @return $this
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;

        return $this;
    }
}