<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Entities;

use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationImpl;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationTranslated;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationUntranslated;

class TranslationTest extends MockeryTestCase
{
    public function test_isEqual()
    {
        $trans1 = new TranslationTranslated();
        $trans2 = new TranslationImpl(TranslationTranslated::MSG_ID, '', '', '', '', '');

        assertThat($trans1->isEqualTo($trans2), is(true));
        assertThat($trans1->isEqualTo('123abc'), is(false));
        assertThat($trans1->isEqualTo(new TranslationUntranslated()), is(false));

    }

    public function test___toString()
    {
        $trans = new TranslationImpl('_toString uses token','', '', '', '', '');
        assertThat((string)$trans, is(equalTo('_toString uses token')));

        $trans = new TranslationImpl('_toString uses token','_to string prefers source string', '', '', '', '');
        assertThat((string)$trans, is(equalTo('_to string prefers source string')));

        $trans = new TranslationImpl('_toString uses token','_to string prefers source string', '_to string really likes locale strings', '', '', '');
        assertThat((string)$trans, is(equalTo('_to string really likes locale strings')));


    }
}