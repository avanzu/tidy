<?php
/**
 * UserCollectionResponseTransformerTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User\DTO;

use Tidy\Responders\User\UserResponse;
use Tidy\Tests\Unit\Entities\UserStub1;
use Tidy\UseCases\User\DTO\UserCollectionResponseDTO;
use Tidy\UseCases\User\DTO\UserCollectionResponseTransformer;
use PHPUnit\Framework\TestCase;
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
        $items = [new UserStub1()];
        $page = 1;
        $pageSize = 20;
        $result = $this->transformer->transform($items, $page, $pageSize);
        $this->assertInstanceOf(UserCollectionResponseDTO::class, $result);
        $this->assertEquals($page, $result->getPage());
        $this->assertEquals($pageSize, $result->getPageSize());
        $this->assertInternalType('array', $result->getItems());
        /** @var $item UserResponse */
        list($item) = $result->getItems();
        $this->assertInstanceOf(UserResponse::class, $item);
        $this->assertEquals(UserStub1::ID, $item->getId());

    }

    protected function setUp()
    {
        $this->transformer = new UserCollectionResponseTransformer(
            new UserResponseTransformer()
        );

        //$this->transformer->setItemTransformer(new UserResponseTransformer());
    }

}
