<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 03.05.18
 *
 */

namespace Tidy\Tests\Unit\Components\Collections;

use Tidy\Components\Collection\HashMap;
use Tidy\Tests\MockeryTestCase;

class HashMapTest extends MockeryTestCase
{

    public function test_Join()
    {
        $input = ['key1' => 'some value', 'key2' => 'some other value'];
        $map   = new HashMap($input);

        assertThat(join(PHP_EOL, $input), is(equalTo($map->join())));
    }

    public function test_list()
    {
        $input    = ['key1' => 'some value', 'key2' => 'some other value'];
        $expected = implode(PHP_EOL, ['* some value', '* some other value']);
        $map      = new HashMap($input);
        assertThat($map->list(), is(equalTo($expected)));

    }
}