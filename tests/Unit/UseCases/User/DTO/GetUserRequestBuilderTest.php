<?php
/**
 * GetUserRequestBuilderTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User\DTO;

use PHPUnit\Framework\TestCase;
use Tidy\Requestors\User\IGetUserRequest;
use Tidy\UseCases\User\DTO\GetUserRequestBuilder;

/**
 * Class GetUserRequestBuilderTest
 */
class GetUserRequestBuilderTest extends TestCase
{
    /**
     * @var GetUserRequestBuilder
     */
    protected $builder;

    /**
     *
     */
    public function testInstantiation()
    {
        $this->assertInstanceOf(GetUserRequestBuilder::class, $this->builder);
    }

    /**
     *
     */
    public function testWithUserId_WithoutExistingRequest_ShouldNotFail()
    {
        $this->assertSame($this->builder, $this->builder->withUserId(123));
        $result = $this->builder->build();
        $this->assertInstanceOf(IGetUserRequest::class, $result);
        $this->assertEquals(123, $result->getUserId());
    }


    /**
     *
     */
    public function testBuild()
    {
        $result = $this->builder->build();
        $this->assertInstanceOf(IGetUserRequest::class, $result);
        $this->assertNotSame($result, $this->builder->create()->build());

    }


    /**
     *
     */
    protected function setUp()
    {
        $this->builder = new GetUserRequestBuilder();
    }


}
