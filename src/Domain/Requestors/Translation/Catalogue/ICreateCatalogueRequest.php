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
     * @return string
     */
    public function name();

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