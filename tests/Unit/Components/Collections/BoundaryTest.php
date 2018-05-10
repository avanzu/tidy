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
        assertThat($boundary->page, is(equalTo(Boundary::DEFAULT_PAGE)));
        assertThat($boundary->pageSize, is(equalTo(Boundary::DEFAULT_PAGE_SIZE)));
    }

    public function test_offset()
    {
        $boundary = new Boundary(1, 30);
        assertThat($boundary->offset(), is(equalTo(0)));
        $boundary->page = 5;
        assertThat($boundary->offset(), is(equalTo(120)));
    }
}