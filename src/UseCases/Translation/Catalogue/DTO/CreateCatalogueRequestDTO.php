<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

use Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest;

/**
 * Class CreateCatalogueRequestDTO
 */
class CreateCatalogueRequestDTO implements ICreateCatalogueRequest
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $sourceLanguage;

    /**
     * @var string
     */
    public $sourceCulture;

    /**
     * @var string
     */
    public $targetLanguage;

    /**
     * @var string
     */
    public $targetCulture;

    /**
     * @var int
     */
    public $projectId;

    /**
     * @var string
     */
    public $canonical;

    /**
     * @return \Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest
     */
    public static function make()
    {
        return new self();
    }

    /**
     * @return string
     */
    public function canonical()
    {
        return $this->canonical;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function projectId()
    {
        return $this->projectId;
    }

    /**
     * @return string
     */
    public function sourceCulture()
    {
        return $this->sourceCulture;
    }

    /**
     * @return string
     */
    public function sourceLanguage()
    {
        return $this->sourceLanguage;
    }

    /**
     * @return string
     */
    public function targetCulture()
    {
        return $this->targetCulture;
    }

    /**
     * @return string
     */
    public function targetLanguage()
    {
        return $this->targetLanguage;
    }

    /**
     * @param $string
     *
     * @return \Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest
     */
    public function withCanonical($string)
    {
        $this->canonical = $string;

        return $this;
    }

    /**
     * @param $name
     *
     * @return \Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest
     */
    public function withName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $projectId
     *
     * @return \Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest
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
     * @return \Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest
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
     * @return ICreateCatalogueRequest
     */
    public function withTargetLocale($language, $culture = null)
    {
        $this->targetLanguage = $language;
        $this->targetCulture  = $culture;

        return $this;
    }

}