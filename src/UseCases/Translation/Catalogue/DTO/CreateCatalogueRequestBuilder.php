<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

class CreateCatalogueRequestBuilder
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $sourceLanguage;

    /**
     * @var string
     */
    protected $sourceCulture;

    /**
     * @var string
     */
    protected $targetLanguage;

    /**
     * @var string
     */
    protected $targetCulture;

    /**
     * @var int
     */
    protected $projectId;

    /**
     * @var string
     */
    protected $canonical;


    /**
     * @param $string
     *
     * @return $this
     */
    public function withCanonical($string)
    {
        $this->canonical = $string;

        return $this;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function withName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $projectId
     *
     * @return $this
     */
    public function withProjectId($projectId)
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * @param      $language
     * @param null $culture
     *
     * @return $this
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
     * @return $this
     */
    public function withTargetLocale($language, $culture = null)
    {
        $this->targetLanguage = $language;
        $this->targetCulture  = $culture;

        return $this;
    }

    public function build()
    {
        return new CreateCatalogueRequestDTO(
            $this->name,
            $this->sourceLanguage,
            $this->sourceCulture,
            $this->targetLanguage,
            $this->targetCulture,
            $this->projectId,
            $this->canonical
        );
    }
}