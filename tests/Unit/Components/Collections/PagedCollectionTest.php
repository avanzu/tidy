<?php
/**
 * PagedCollectionTest.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\Tests\Unit\Components\Collections;

use PHPUnit\Framework\TestCase;
use Tidy\Components\Collection\ICollection;
use Tidy\Components\Collection\IPagedCollection;
use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Requestors\ICollectionRequest;

/**
 * Class PagedCollectionTest
 */
class PagedCollectionTest extends TestCase
{
    /**
     * @var IPagedCollection
     */
    private $collection;

    /**
     *
     */
    public function test_objectStructure_implements_arrayAlikeInterfaces()
    {
        $this->assertInstanceOf(IPagedCollection::class, $this->collection);
        $this->assertInstanceOf(\Countable::class, $this->collection);
        $this->assertInstanceOf(\IteratorAggregate::class, $this->collection);
        $this->assertInstanceOf(ICollection::class, $this->collection);

    }

    /**
     *
     */
    public function test_newInstance_DefaultValues()
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
    public function test_ArrayLikeness()
    {
        $items       = [1, 2];
        $totalItems  = 33;
        $currentPage = 3;
        $pageSize    = 10;

        $this->collection = new PagedCollection(
            $items, $totalItems, $currentPage, $pageSize
        );


        $loop = 1;
        foreach ($this->collection as $item) {
            $this->assertEquals($loop++, $item);
        }
    }

    /**
     *
     */
    public function test_mapCallback_isExecuted()
    {
        $items            = array_fill(0, 5, uniqid());
        $this->collection = new PagedCollection($items);
        foreach ($this->collection->map(function ($item) { return '#'.$item; }) as $item) {
            $this->assertStringStartsWith('#', $item);
        }
    }


    /**
     *
     */
    public function test_boundaries_evaluateFromInput()
    {
        $items      = array_fill(0, 30, uniqid());
        $collection = new PagedCollection($items, null, 2, 10);

        $this->assertEquals(30, $collection->getPageSize());
        $this->assertEquals(1, $collection->getPagesTotal());
        $this->assertEquals(1, $collection->getPage());

    }


    public function test_boundary_assignment()
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
    }


    /**
     *
     */
    protected function setUp()
    {
        $this->collection = new PagedCollection();
    }
}
