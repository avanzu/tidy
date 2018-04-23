<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Components\Normalisation;

class TextNormaliser implements ITextNormaliser
{

    public function transform($string)
    {

        /*
        $string = transliterator_transliterate("Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();", $string);
        $string = preg_replace('/[-\s]+/', '-', $string);
        */

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $clean = preg_replace("![^a-zA-Z0-9/_| -]!", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("![/_| -]+!", '-', $clean);

        return trim($clean, '-');

        //return trim($string, '-');
    }
}