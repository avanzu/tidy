<?php
/**
 * GetUserCollectionRequestBuilderTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User\DTO;

use PHPUnit\Framework\TestCase;
use Tidy\Requestors\User\IGetUserCollectionRequest;
use Tidy\Requestors\User\IGetUserCollectionRequestBuilder;
use Tidy\UseCases\User\DTO\GetUserCollectionRequestBuilder;
use Tidy\UseCases\User\DTO\GetUserCollectionRequestDTO;

/**
 * Class GetUserCollectionRequestBuilderTest
 */
class GetUserCollectionRequestBuilderTest extends TestCase
{

    /**
     * @var IGetUserCollectionRequestBuilder
     */
    private $builder;

    /**
     *
     */
    public function testInstantiation()
    {
        $this->assertInstanceOf(GetUserCollectionRequestBuilder::class, $this->builder);
    }

    /**
     *
     */
    public function testBuildReturnsCollectionRequest()
    {
        $result = $this->builder->withPageSize(20)->fromPage(5)->build();
        $this->assertInstanceOf(GetUserCollectionRequestDTO::class, $result);
        $this->assertEquals(20, $result->getPageSize());
        $this->assertEquals(5, $result->getPage());

        $result2 = $this->builder->create()->build();
        $this->assertNotSame($result, $result2);

        $this->assertSame($result2, $this->builder->build());
    }

    /**
     *
     */
    public function testDefaultValuesAreDefined()
    {
        $result = $this->builder->build();
        $this->assertEquals(1, $result->getPage());
        $this->assertEquals(20, $result->getPageSize());
    }



    /**
     *
     */
    protected function setUp()
    {
        $this->builder = new GetUserCollectionRequestBuilder();
    }


}
