<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Tests\Unit\Components\Normalisation;

use Tidy\Components\Normalisation\TextNormaliser;
use Tidy\Tests\MockeryTestCase;

class TextNormaliserTest extends MockeryTestCase
{

    /**
     * @dataProvider provideStrings
     */
    public function test_transform($input, $expected)
    {
        $normaliser = new TextNormaliser();
        assertThat($normaliser->transform($input), is(equalTo($expected)));
    }

    public function provideStrings() {
        return [
            ['abc', 'abc'],
            ['ABC', 'abc'],
            ['A b C', 'a-b-c'],
            ['', ''],
            ['ÄÖÜß', 'aeoeuess'],
            ['- Test --__..+??)?', 'test'],
            ['!"§$%&/())(/&%$§"§$%&/()*Ä_:""', 'ae'],

            // depending on the system configuration, we might not be able to transliterate chinese
            ['(第二次漢字簡化方案（草案） / 第二次汉字简化方案（草案）', ''],
            [' 通用规范汉字表', '']
        ];
    }
}