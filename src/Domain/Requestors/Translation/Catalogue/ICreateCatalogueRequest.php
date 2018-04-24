<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Requestors\Translation\Catalogue;

/**
 * Class CreateCatalogueRequestDTO
 */
interface ICreateCatalogueRequest
{
    /**
     * @param $name
     *
     * @return ICreateCatalogueRequest
     */
    public function withName($name);

    /**
     * @param      $language
     * @param null $culture
     *
     * @return ICreateCatalogueRequest
     */
    public function withSourceLocale($language, $culture = null);

    /**
     * @param      $language
     * @param null $culture
     *
     * @return ICreateCatalogueRequest
     */
    public function withTargetLocale($language, $culture = null);

    /**
     * @param $projectId
     *
     * @return ICreateCatalogueRequest
     */
    public function withProjectId($projectId);

    /**
     * @return string
     */
    public function name();

    /**
     * @param $string
     *
     * @return ICreateCatalogueRequest
     */
    public function withCanonical($string);

    /**
     * @return string
     */
    public function canonical();

    /**
     * @return string
     */
    public function sourceLanguage();

    /**
     * @return string
     */
    public function sourceCulture();

    /**
     * @return string
     */
    public function targetLanguage();

    /**
     * @return string
     */
    public function targetCulture();

    /**
     * @return int
     */
    public function projectId();
}