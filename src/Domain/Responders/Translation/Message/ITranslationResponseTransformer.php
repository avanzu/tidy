<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Responders\Translation\Message;

use Tidy\Domain\Entities\Translation;

interface ITranslationResponseTransformer
{
    public function transform(Translation $translation);
}