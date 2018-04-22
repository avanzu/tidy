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
        $this->assertNotNull($boundary);

        $this->assertEquals(2, $boundary->page);
        $this->assertEquals(25, $boundary->pageSize);
    }

    public function test_defaults()
    {
        $boundary = new Boundary();
        $this->assertEquals(Boundary::DEFAULT_PAGE, $boundary->page);
        $this->assertEquals(Boundary::DEFAULT_PAGE_SIZE, $boundary->pageSize);
    }
}