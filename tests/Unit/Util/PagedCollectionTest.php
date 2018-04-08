<?php
/**
 * PagedCollectionTest.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\Tests\Unit\Util;

use PHPUnit\Framework\TestCase;
use Tidy\Requestors\ICollectionRequest;
use Tidy\Util\PagedCollection;

/**
 * Class PagedCollectionTest
 */
class PagedCollectionTest extends TestCase
{
    /**
     * @var PagedCollection
     */
    private $collection;

    /**
     *
     */
    public function testInstantiation()
    {
        $this->assertInstanceOf(PagedCollection::class, $this->collection);
        $this->assertInstanceOf(\Countable::class, $this->collection);
        $this->assertInstanceOf(\IteratorAggregate::class, $this->collection);
    }

    /**
     *
     */
    public function testDefaultValues()
    {
        $this->assertEquals(ICollectionRequest::DEFAULT_PAGE, $this->collection->getPage());
        $this->assertEquals(ICollectionRequest::DEFAULT_PAGE, $this->collection->getPagesTotal());
        $this->assertEquals(ICollectionRequest::DEFAULT_PAGE_SIZE, $this->collection->getPageSize());
        $this->assertEquals(0, $this->collection->getTotal());
        $this->assertEquals(0, $this->collection->count());

    }

    /**
     *
     */
    public function testArrayLikeness()
    {
        $items       = [1, 2];
        $totalItems  = 33;
        $currentPage = 3;
        $pageSize    = 10;

        $this->collection = new PagedCollection(
            $items, $totalItems, $currentPage, $pageSize
        );

        $this->assertEquals($currentPage, $this->collection->getPage());
        $this->assertEquals(33, $this->collection->getTotal());
        $this->assertEquals(4, $this->collection->getPagesTotal());
        $this->assertCount(2, $this->collection);


        $loop = 1;
        foreach ($this->collection as $item) {
            $this->assertEquals($loop++, $item);
        }
    }

    /**
     *
     */
    public function testMapCallback()
    {
        $items            = array_fill(0, 5, uniqid());
        $this->collection = new PagedCollection($items);
        foreach ( $this->collection->map(function($item){ return '#'.$item; }) as $item) {
            $this->assertStringStartsWith('#', $item);
        }
    }


    /**
     *
     */
    public function testStateIsAlwaysValid()
    {
        $items      = array_fill(0, 30, uniqid());
        $collection = new PagedCollection($items, null, 2, 10);

        $this->assertEquals(30, $collection->getPageSize());
        $this->assertEquals(1, $collection->getPagesTotal());
        $this->assertEquals(1, $collection->getPage());

    }


    /**
     *
     */
    protected function setUp()
    {
        $this->collection = new PagedCollection();
    }


}
