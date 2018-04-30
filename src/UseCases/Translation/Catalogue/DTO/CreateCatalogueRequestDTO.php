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
     * CreateCatalogueRequestDTO constructor.
     *
     * @param string $name
     * @param string $sourceLanguage
     * @param string $sourceCulture
     * @param string $targetLanguage
     * @param string $targetCulture
     * @param int    $projectId
     * @param string $canonical
     */
    public function __construct(
        $name,
        $sourceLanguage,
        $sourceCulture,
        $targetLanguage,
        $targetCulture,
        $projectId,
        $canonical
    ) {
        $this->name           = $name;
        $this->sourceLanguage = $sourceLanguage;
        $this->sourceCulture  = $sourceCulture;
        $this->targetLanguage = $targetLanguage;
        $this->targetCulture  = $targetCulture;
        $this->projectId      = $projectId;
        $this->canonical      = $canonical;
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

}