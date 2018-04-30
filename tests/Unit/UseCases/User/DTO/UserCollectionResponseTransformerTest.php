<?php
/**
 * UserCollectionResponseTransformerTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User\DTO;

use PHPUnit\Framework\TestCase;
use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Responders\User\ICollectionResponseTransformer;
use Tidy\Domain\Responders\User\IResponse;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\Tests\Unit\Fixtures\Entities\UserStub1;
use Tidy\UseCases\User\DTO\CollectionResponseDTO;
use Tidy\UseCases\User\DTO\CollectionResponseTransformer;
use Tidy\UseCases\User\DTO\ResponseTransformer;

/**
 * Class UserCollectionResponseTransformerTest
 */
class UserCollectionResponseTransformerTest extends TestCase
{

    /**
     * @var ICollectionResponseTransformer
     */
    private $transformer;

    /**
     *
     */
    public function testInstantiation()
    {
        $this->assertInstanceOf(CollectionResponseTransformer::class, $this->transformer);
    }


    /**
     *
     */
    public function test_transform_returnsUserCollectionResponse()
    {
        $items  = [];
        $result = $this->transformer->transform(new PagedCollection($items, 10, 1, 20));
        $this->assertInstanceOf(CollectionResponseDTO::class, $result);
        $this->assertCount(0, $result);

    }

    /**
     *
     */
    public function test_UserCollectionResponse_containsValidBoundaries()
    {
        $items    = [];
        $page     = 1;
        $pageSize = 20;
        $total    = 10;
        $result   = $this->transformer->transform(new PagedCollection($items, $total, $page, $pageSize));

        $this->assertEquals($page, $result->currentPage());
        $this->assertEquals($pageSize, $result->pageSize());
        $this->assertEquals($total, $result->total());
        $this->assertInternalType('array', $result->getItems());
    }


    /**
     *
     */
    public function test_itemTransformation_createsUserResponse()
    {
        $items    = [new UserStub1()];
        $page     = 1;
        $pageSize = 20;
        $result   = $this->transformer->transform(new PagedCollection($items, 10, $page, $pageSize));

        /** @var $item IResponse */
        list($item) = $result->getItems();
        $this->assertInstanceOf(IResponse::class, $item);
        $this->assertEquals(UserStub1::ID, $item->getId());

    }


    /**
     *
     */
    public function test_swapItemTransformer_AcceptsNewTransformer_ReturnsCurrentTransformer()
    {
        $transformer     = new CollectionResponseTransformer(mock(IResponseTransformer::class));
        $itemTransformer = new ResponseTransformer();
        $lastTransformer = $transformer->swapItemTransformer($itemTransformer);
        $this->assertSame($itemTransformer, $transformer->swapItemTransformer($lastTransformer));

    }

    /**
     *
     */
    protected function setUp()
    {
        $this->transformer = new CollectionResponseTransformer();

    }

}
