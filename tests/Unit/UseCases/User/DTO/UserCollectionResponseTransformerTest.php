<?php
/**
 * UserCollectionResponseTransformerTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User\DTO;

use PHPUnit\Framework\TestCase;
use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Responders\User\IUserCollectionResponseTransformer;
use Tidy\Domain\Responders\User\IUserResponse;
use Tidy\Tests\Unit\Domain\Entities\UserStub1;
use Tidy\UseCases\User\DTO\UserCollectionResponseDTO;
use Tidy\UseCases\User\DTO\UserCollectionResponseTransformer;
use Tidy\UseCases\User\DTO\UserResponseTransformer;

/**
 * Class UserCollectionResponseTransformerTest
 */
class UserCollectionResponseTransformerTest extends TestCase
{

    /**
     * @var IUserCollectionResponseTransformer
     */
    private $transformer;

    /**
     *
     */
    public function testInstantiation()
    {
        $this->assertInstanceOf(UserCollectionResponseTransformer::class, $this->transformer);
    }


    /**
     *
     */
    public function test_transform_returnsUserCollectionResponse()
    {
        $items  = [];
        $result = $this->transformer->transform(new PagedCollection($items, 10, 1, 20));
        $this->assertInstanceOf(UserCollectionResponseDTO::class, $result);
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

        $this->assertEquals($page, $result->getPage());
        $this->assertEquals($pageSize, $result->getPageSize());
        $this->assertEquals($total, $result->getTotal());
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

        /** @var $item IUserResponse */
        list($item) = $result->getItems();
        $this->assertInstanceOf(IUserResponse::class, $item);
        $this->assertEquals(UserStub1::ID, $item->getId());

    }


    /**
     *
     */
    public function test_swapItemTransformer_AcceptsNewTransformer_ReturnsCurrentTransformer()
    {
        $itemTransformer = new UserResponseTransformer();
        $lastTransformer = $this->transformer->swapItemTransformer($itemTransformer);
        $this->assertSame($itemTransformer, $this->transformer->swapItemTransformer($lastTransformer));

    }

    /**
     *
     */
    protected function setUp()
    {
        $this->transformer = new UserCollectionResponseTransformer();

    }

}
