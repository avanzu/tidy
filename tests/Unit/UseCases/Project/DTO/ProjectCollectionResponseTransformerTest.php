<?php
/**
 * ProjectCollectionResponseTransformerTest.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project\DTO;

use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Responders\Project\ICollectionResponseTransformer;
use Tidy\Domain\Responders\Project\IResponse;
use Tidy\Domain\Responders\Project\IResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\ProjectSilverTongue;
use Tidy\UseCases\Project\DTO\CollectionResponseDTO;
use Tidy\UseCases\Project\DTO\CollectionResponseTransformer;
use Tidy\UseCases\Project\DTO\ResponseTransformer;

class ProjectCollectionResponseTransformerTest extends MockeryTestCase
{


    /**
     * @var ICollectionResponseTransformer
     */
    protected $transformer;

    public function test_instantiation()
    {
        $transformer = new CollectionResponseTransformer();
        $this->assertInstanceOf(CollectionResponseTransformer::class, $transformer);
    }

    public function test_swapItemTransformer()
    {
        $transformer = new CollectionResponseTransformer(mock(IResponseTransformer::class));
        $next        = mock(ResponseTransformer::class);
        $previous    = $transformer->swapItemTransformer($next);
        $this->assertInstanceOf(IResponseTransformer::class, $previous);
        $this->assertNotSame($previous, $next);

        $this->assertSame($next, $transformer->swapItemTransformer($previous));
    }

    /**
     *
     */
    public function test_transform_returnsProjectCollectionResponse()
    {
        $items  = [];
        $result = $this->transformer->transform(new PagedCollection($items, 10, 1, 20));
        $this->assertInstanceOf(CollectionResponseDTO::class, $result);
        $this->assertEquals(1, $result->currentPage());
        $this->assertEquals(1, $result->pagesTotal());
        $this->assertEquals(20, $result->pageSize());
    }

    public function test_transform_callsItemTransformerForItems()
    {
        $items  = [new ProjectSilverTongue()];
        $result = $this->transformer->transform(new PagedCollection($items));
        $this->assertCount(1, $result);
        $this->assertInstanceOf(IResponse::class, current($result->getItems()));
    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->transformer = new CollectionResponseTransformer();

    }
}