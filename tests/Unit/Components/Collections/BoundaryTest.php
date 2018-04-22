<?php
/**
 * BoundaryTest.php
 * Tidy
 * Date: 22.04.18
 */

namespace Tidy\Tests\Unit\Components\Collections;

use Tidy\Components\Collection\Boundary;
use Tidy\Tests\MockeryTestCase;

class BoundaryTest extends MockeryTestCase
{
    public function test_instantiation()
    {
        $boundary = new Boundary(2, 25);
        assertThat($boundary->page, is(equalTo(2)));
        assertThat($boundary->pageSize, is(equalTo(25)));

    }

    public function test_defaults()
    {
        $boundary = new Boundary();
        $this->assertEquals(Boundary::DEFAULT_PAGE, $boundary->page);
        $this->assertEquals(Boundary::DEFAULT_PAGE_SIZE, $boundary->pageSize);
    }
}