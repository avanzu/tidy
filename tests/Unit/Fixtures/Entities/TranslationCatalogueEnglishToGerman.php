<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\Fixtures\Entities;


class TranslationCatalogueEnglishToGerman extends TranslationCatalogueImpl
{
    const ID             = 4711;
    const TARGET_CULTURE = 'DE';
    const SOURCE_CULTURE = 'US';
    const TARGET_LANG    = 'de';
    const SOURCE_LANG    = 'en';
    const NAME           = 'Messages';
    const CANONICAL      = 'messages';

    protected $name           = self::NAME;

    protected $id             = self::ID;

    protected $canonical      = self::CANONICAL;

    protected $sourceLanguage = self::SOURCE_LANG;

    protected $targetLanguage = self::TARGET_LANG;

    protected $sourceCulture  = self::SOURCE_CULTURE;

    protected $targetCulture  = self::TARGET_CULTURE;

    /**
     * TranslationCatalogueEnglishToGerman constructor.
     */
    public function __construct()
    {
        $this->project = new ProjectSilverTongue();
        $this->add(new TranslationTranslated());
        $this->add(new TranslationUntranslated());
    }


}