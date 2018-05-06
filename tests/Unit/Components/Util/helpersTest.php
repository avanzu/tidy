<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 06.05.18
 *
 */

namespace Tidy\Tests\Unit\Components\Util;

use Tidy\Tests\MockeryTestCase;

class helpersTest extends MockeryTestCase
{
    public function testCoalesce()
    {
        $this->assertEquals('abc', coalesce('abc', '123'));
        $this->assertEquals('123', coalesce(null, '123'));
        $this->assertEquals('', coalesce('', 'should be empty string'));
        $this->assertEquals(false, coalesce(false, 'should be false'));
        $this->assertEquals(null, coalesce(null, null, null));
    }
}