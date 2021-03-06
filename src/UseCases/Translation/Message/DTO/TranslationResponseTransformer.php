<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\Message\DTO;

use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponseTransformer;

class TranslationResponseTransformer implements ITranslationResponseTransformer
{

    public function transform(Translation $translation)
    {

        $response               = new TranslationResponseDTO();
        $response->id           = $translation->getId();
        $response->token        = $translation->getToken();
        $response->sourceString = $translation->getSourceString();
        $response->localeString = $translation->getLocaleString();
        $response->meaning      = $translation->getMeaning();
        $response->notes        = $translation->getNotes();
        $response->state        = $translation->getState();

        return $response;
    }
}