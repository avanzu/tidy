<?php
/**
 * This file is part of the Tidy Project.
 *
 * TranslationTranslated.php Created by avanzu on 22.04.18 with PhpStorm.
 *
 */

namespace Tidy\Tests\Unit\Domain\Entities;

use Tidy\Domain\Entities\Translation;

class TranslationTranslated extends Translation
{
    const MSG_STATE   = 'translated';
    const MSG_NOTES   = 'Integer sed lacus sapien. Ut ac porta risus. ';
    const MSG_MEANING = 'Greet the world';
    const MSG_TARGET  = 'Hallo Welt! ';
    const MSG_SOURCE  = 'Hello World! ';
    const MSG_ID      = 'message.hello';
    const ID          = 2507;

    protected $id           = self::ID;

    protected $token        = self::MSG_ID;

    protected $sourceString = self::MSG_SOURCE;

    protected $localeString = self::MSG_TARGET;

    protected $meaning      = self::MSG_MEANING;

    protected $notes        = self::MSG_NOTES;

    protected $state        = self::MSG_STATE;
}