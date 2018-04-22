<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

class CreateCatalogueRequestDTO
{
    public    $name;

    public    $sourceLanguage;

    public    $sourceCulture;

    public    $targetLanguage;

    public    $targetCulture;

    public    $projectId;

    public $canonical;

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

    public function sourceLanguage() {
        return $this->sourceLanguage;
    }

    public function sourceCulture() {
        return $this->sourceCulture;
    }

    public function targetLanguage()
    {
        return $this->targetLanguage;
    }

    public function targetCulture()
    {
        return $this->targetCulture;
    }

}