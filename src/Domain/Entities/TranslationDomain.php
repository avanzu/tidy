<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 30.04.18
 *
 */

namespace Tidy\Domain\Entities;

/**
 * Class TranslationDomain represents the fully qualified translation domain
 */
class TranslationDomain
{
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
     * @var string
     */
    protected $canonical;

    /**
     * TranslationDomain constructor.
     *
     * @param string $canonical
     * @param string $sourceLanguage
     * @param string $sourceCulture
     * @param string $targetLanguage
     * @param string $targetCulture
     */
    public function __construct(
        string $canonical,
        string $sourceLanguage,
        string $sourceCulture,
        string $targetLanguage,
        string $targetCulture
    ) {
        $this->sourceLanguage = $sourceLanguage;
        $this->sourceCulture  = $sourceCulture;
        $this->targetLanguage = $targetLanguage;
        $this->targetCulture  = $targetCulture;
        $this->canonical      = $canonical;
    }


    /**
     * @return string
     */
    public function getSourceLanguage()
    {
        return $this->sourceLanguage;
    }

    /**
     * @return string
     */
    public function getSourceCulture()
    {
        return $this->sourceCulture;
    }

    /**
     * @return string
     */
    public function getTargetLanguage()
    {
        return $this->targetLanguage;
    }

    /**
     * @return string
     */
    public function getTargetCulture()
    {
        return $this->targetCulture;
    }

    /**
     * @return string
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @return string
     */
    public function sourceLocale()
    {

        return implode('-', array_filter([$this->getSourceLanguage(), $this->getSourceCulture()]));
    }

    /**
     * @return string
     */
    public function targetLocale()
    {
        return implode('-', array_filter([$this->getTargetLanguage(), $this->getTargetCulture()]));
    }

    public function __toString()
    {
        return sprintf('%s.%s.%s', $this->getCanonical(), $this->sourceLocale(), $this->targetLocale());
    }

}