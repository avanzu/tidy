<?php
/**
 * UserCollectionResponseTransformerTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User\DTO;

use PHPUnit\Framework\TestCase;
use Tidy\Responders\User\IUserCollectionResponseTransformer;
use Tidy\Responders\User\IUserResponse;
use Tidy\Tests\Unit\Entities\UserStub1;
use Tidy\UseCases\User\DTO\UserCollectionResponseDTO;
use Tidy\UseCases\User\DTO\UserCollectionResponseTransformer;
use Tidy\UseCases\User\DTO\UserResponseTransformer;
use Tidy\Util\PagedCollection;

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
    public function testTransformation()
    {
        $items      = [new UserStub1()];
        $page       = 1;
        $pageSize   = 20;
        $result     = $this->transformer->transform(new PagedCollection($items, 10, $page, $pageSize));
        $this->assertInstanceOf(UserCollectionResponseDTO::class, $result);
        $this->assertEquals($page, $result->getPage());
        $this->assertEquals($pageSize, $result->getPageSize());
        $this->assertInternalType('array', $result->getItems());
        /** @var $item IUserResponse */
        list($item) = $result->getItems();
        $this->assertInstanceOf(IUserResponse::class, $item);
        $this->assertEquals(UserStub1::ID, $item->getId());

    }

    /**
     *
     */
    public function testItemTransformerAssignment()
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
