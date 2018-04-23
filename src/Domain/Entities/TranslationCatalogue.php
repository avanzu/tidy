<?php
/**
 * This file is part of the Tidy Project.
 *
 * TranslationCatalogue.php Created by avanzu on 22.04.18 with PhpStorm.
 *
 */

namespace Tidy\Domain\Entities;

use ArrayObject;

abstract class TranslationCatalogue
{
    protected $sourceLanguage;

    protected $sourceCulture;

    protected $targetLanguage;

    protected $targetCulture;

    protected $name;

    protected $id;

    protected $canonical;

    /**
     * @var Translation[]|ArrayObject
     */
    protected $translations;

    /**
     * @var Project
     */
    protected $project;

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     *
     * @return $this
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }


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

    public function path() {
        return implode('/', [$this->getCanonical(), $this->sourceLocale(), $this->targetLocale()]);
    }

    public function sourceLocale() {
        return implode('-', array_filter([$this->sourceLanguage, $this->sourceCulture]));
    }

    public function targetLocale()
    {
        return implode('-', array_filter([$this->targetLanguage, $this->targetCulture]));
    }

    protected function translations()
    {
        if (!$this->translations) {
            $this->translations = new ArrayObject();
        }

        return $this->translations;
    }

    public function addTranslation(Translation $translation)
    {
        $this->translations()->offsetSet($translation->getToken(), $translation);

        return $this;
    }

    /**
     * @param $token
     *
     * @return Translation|null
     */
    public function find($token)
    {
        if ($this->translations()->offsetExists($token)) {
            return $this->translations()->offsetGet($token);
        }

        return null;
    }

    /**
     * @param callable $callback
     *
     * @return array
     */
    public function map(callable $callback)
    {
        return array_map($callback, $this->translations()->getArrayCopy());
    }
}