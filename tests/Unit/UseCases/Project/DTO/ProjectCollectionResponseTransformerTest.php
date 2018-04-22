<?php
/**
 * ProjectCollectionResponseTransformerTest.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project\DTO;

use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Responders\Project\IProjectCollectionResponseTransformer;
use Tidy\Domain\Responders\Project\IProjectResponse;
use Tidy\Domain\Responders\Project\IProjectResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\ProjectSilverTongue;
use Tidy\UseCases\Project\DTO\ProjectCollectionResponseDTO;
use Tidy\UseCases\Project\DTO\ProjectCollectionResponseTransformer;
use Tidy\UseCases\Project\DTO\ProjectResponseTransformer;

class ProjectCollectionResponseTransformerTest extends MockeryTestCase
{


    /**
     * @var IProjectCollectionResponseTransformer
     */
    protected $transformer;

    public function test_instantiation()
    {
        $transformer = new ProjectCollectionResponseTransformer();
        $this->assertInstanceOf(ProjectCollectionResponseTransformer::class, $transformer);
    }

    public function test_swapItemTransformer()
    {
        $next     = mock(ProjectResponseTransformer::class);
        $previous = $this->transformer->swapItemTransformer($next);
        $this->assertInstanceOf(IProjectResponseTransformer::class, $previous);
        $this->assertNotSame($previous, $next);

        $this->assertSame($next, $this->transformer->swapItemTransformer($previous));
    }

    /**
     *
     */
    public function test_transform_returnsProjectCollectionResponse()
    {
        $items  = [];
        $result = $this->transformer->transform(new PagedCollection($items, 10, 1, 20));
        $this->assertInstanceOf(ProjectCollectionResponseDTO::class, $result);
        $this->assertEquals(1, $result->currentPage());
        $this->assertEquals(1, $result->pagesTotal());
        $this->assertEquals(20, $result->pageSize());
    }

    public function test_transform_callsItemTransformerForItems()
    {
        $items = [new ProjectSilverTongue()];
        $result = $this->transformer->transform(new PagedCollection($items));
        $this->assertCount(1, $result);
        $this->assertInstanceOf(IProjectResponse::class, current($result->getItems()));
    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->transformer = new ProjectCollectionResponseTransformer();

    }
}