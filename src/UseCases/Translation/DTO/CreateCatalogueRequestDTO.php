<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

/**
 * Class CreateCatalogueRequestDTO
 */
class CreateCatalogueRequestDTO
{
    /**
     * @var string
     */
    public    $name;

    /**
     * @var string
     */
    public    $sourceLanguage;

    /**
     * @var string
     */
    public    $sourceCulture;

    /**
     * @var string
     */
    public    $targetLanguage;

    /**
     * @var string
     */
    public    $targetCulture;

    /**
     * @var int
     */
    public    $projectId;

    /**
     * @var string
     */
    public $canonical;

    /**
     * @return CreateCatalogueRequestDTO
     */
    public static function make()
    {
        return new self();
    }

    /**
     * @param $name
     *
     * @return CreateCatalogueRequestDTO
     */
    public function withName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @param      $language
     * @param null $culture
     *
     * @return CreateCatalogueRequestDTO
     */
    public function withSourceLocale($language, $culture = null)
    {
        $this->sourceLanguage = $language;
        $this->sourceCulture  = $culture;

        return $this;

    }

    /**
     * @param      $language
     * @param null $culture
     *
     * @return CreateCatalogueRequestDTO
     */
    public function withTargetLocale($language, $culture = null)
    {
        $this->targetLanguage = $language;
        $this->targetCulture  = $culture;

        return $this;
    }

    /**
     * @param $projectId
     *
     * @return CreateCatalogueRequestDTO
     */
    public function withProjectId($projectId)
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * @return string
     */
    public function name() {
        return $this->name;
    }

    /**
     * @param $string
     *
     * @return CreateCatalogueRequestDTO
     */
    public function withCanonical($string) {
        $this->canonical = $string;
        return $this;
    }

    /**
     * @return string
     */
    public function canonical() {
        return $this->canonical;
    }

    /**
     * @return string
     */
    public function sourceLanguage() {
        return $this->sourceLanguage;
    }

    /**
     * @return string
     */
    public function sourceCulture() {
        return $this->sourceCulture;
    }

    /**
     * @return string
     */
    public function targetLanguage()
    {
        return $this->targetLanguage;
    }

    /**
     * @return string
     */
    public function targetCulture()
    {
        return $this->targetCulture;
    }

    /**
     * @return int
     */
    public function projectId() {
        return $this->projectId;
    }

}