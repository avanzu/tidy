<?php
/**
 * GetUserCollectionRequestBuilderTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User\DTO;

use PHPUnit\Framework\TestCase;
use Tidy\UseCases\User\DTO\GetUserCollectionRequestBuilder;
use Tidy\UseCases\User\DTO\GetUserCollectionRequestDTO;

class GetUserCollectionRequestBuilderTest extends TestCase
{

    /**
     * @var GetUserCollectionRequestBuilder
     */
    private $builder;

    public function testInstantiation()
    {
        $this->assertInstanceOf(GetUserCollectionRequestBuilder::class, $this->builder);
    }

    public function testBuildReturnsCollectionRequest()
    {
        $result = $this->builder->build();
        $this->assertInstanceOf(GetUserCollectionRequestDTO::class, $result);

        $result2 = $this->builder->create()->build();
        $this->assertNotSame($result, $result2);

        $this->assertSame($result2, $this->builder->build());
    }

    public function testDefaultValuesAreDefined()
    {
        $result = $this->builder->build();
        $this->assertEquals(1, $result->getPage());
        $this->assertEquals(20, $result->getPageSize());
    }



    protected function setUp()
    {
        $this->builder = new GetUserCollectionRequestBuilder();
    }


}
