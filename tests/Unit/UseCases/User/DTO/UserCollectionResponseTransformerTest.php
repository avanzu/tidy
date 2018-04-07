<?php
/**
 * UserCollectionResponseTransformerTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User\DTO;

use PHPUnit\Framework\TestCase;
use Tidy\Responders\User\UserResponse;
use Tidy\Tests\Unit\Entities\UserStub1;
use Tidy\UseCases\User\DTO\UserCollectionResponseDTO;
use Tidy\UseCases\User\DTO\UserCollectionResponseTransformer;
use Tidy\UseCases\User\DTO\UserResponseTransformer;

class UserCollectionResponseTransformerTest extends TestCase
{

    /**
     * @var UserCollectionResponseTransformer
     */
    private $transformer;

    public function testInstantiation()
    {
        $this->assertInstanceOf(UserCollectionResponseTransformer::class, $this->transformer);
    }

    public function testTransformation()
    {
        $items    = [new UserStub1()];
        $page     = 1;
        $pageSize = 20;
        $pagesTotal = 5;
        $result   = $this->transformer->transform($items, $page, $pageSize, $pagesTotal);
        $this->assertInstanceOf(UserCollectionResponseDTO::class, $result);
        $this->assertEquals($page, $result->getPage());
        $this->assertEquals($pageSize, $result->getPageSize());
        $this->assertInternalType('array', $result->getItems());
        /** @var $item UserResponse */
        list($item) = $result->getItems();
        $this->assertInstanceOf(UserResponse::class, $item);
        $this->assertEquals(UserStub1::ID, $item->getId());

    }

    public function testItemTransformerAssignment()
    {
        $itemTransformer = new UserResponseTransformer();
        $lastTransformer = $this->transformer->replaceItemTransformer($itemTransformer);
        $this->assertSame($itemTransformer, $this->transformer->replaceItemTransformer($lastTransformer));

    }

    protected function setUp()
    {
        $this->transformer = new UserCollectionResponseTransformer();

    }

}
