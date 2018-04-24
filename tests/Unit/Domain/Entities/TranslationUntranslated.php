<?php
/**
 * This file is part of the Tidy Project.
 *
 * TranslationUntranslated.php Created by avanzu on 22.04.18 with PhpStorm.
 *
 */

namespace Tidy\Tests\Unit\Domain\Entities;

use Tidy\Domain\Entities\Translation;

class TranslationUntranslated extends Translation
{
    const MSG_STATE   = 'new';
    const MSG_NOTES   = 'Nunc a dolor nulla. Integer quis dignissim ante. ';
    const MSG_MEANING = 'Lorem Ipsum ';
    const MSG_TARGET  = 'Integer quis  ';
    const MSG_SOURCE  = 'Integer quis ';
    const MSG_ID      = 'message.lorem_ipsum';
    const ID          = 220418;

    protected $id           = self::ID;

    protected $token        = self::MSG_ID;

    protected $sourceString = self::MSG_SOURCE;

    protected $localeString = self::MSG_TARGET;

    protected $meaning      = self::MSG_MEANING;

    protected $notes        = self::MSG_NOTES;

    protected $state        = self::MSG_STATE;
}