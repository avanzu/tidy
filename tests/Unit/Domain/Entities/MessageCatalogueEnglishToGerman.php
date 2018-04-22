<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Entities;

use Tidy\Domain\Entities\MessageCatalogue;

class MessageCatalogueEnglishToGerman extends MessageCatalogue
{
    const TARGET_CULTURE = 'DE';
    const SOURCE_CULTURE = 'US';
    const TARGET_LANG    = 'de';
    const SOURCE_LANG    = 'en';
    const NAME           = 'Messages';
    const ID             = 'messages';

    protected $name           = self::NAME;

    protected $id             = self::ID;

    protected $sourceLanguage = self::SOURCE_LANG;

    protected $targetLanguage = self::TARGET_LANG;

    protected $sourceCulture  = self::SOURCE_CULTURE;

    protected $targetCulture  = self::TARGET_CULTURE;




}