<?php
/**
 * GetUserCollectionTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use PHPUnit\Framework\TestCase;
use Tidy\Exceptions\OutOfBounds;
use Tidy\Requestors\User\IGetUserCollectionRequestBuilder;
use Tidy\Responders\User\IUserResponse;
use Tidy\Tests\Unit\Entities\UserStub1;
use Tidy\Tests\Unit\Entities\UserStub2;
use Tidy\Tests\Unit\Gateways\InMemoryIUserGateway;
use Tidy\UseCases\User\DTO\GetUserCollectionRequestBuilder;
use Tidy\UseCases\User\DTO\UserCollectionResponseDTO;
use Tidy\UseCases\User\DTO\UserCollectionResponseTransformer;
use Tidy\UseCases\User\GetUserCollection;

/**
 * Class GetUserCollectionTest
 */
class GetUserCollectionTest extends TestCase
{
    /**
     * @var IGetUserCollectionRequestBuilder
     */
    protected $builder;
    /**
     * @var GetUserCollection
     */
    private $useCase;

    /**
     *
     */
    public function testInstantiation()
    {
        $this->assertInstanceOf(GetUserCollection::class, $this->useCase);
    }


    /**
     *
     */
    public function testLoadCollection()
    {


        InMemoryIUserGateway::$users = [
            UserStub1::ID => new UserStub1(),
            UserStub2::ID => new UserStub2(),
        ];

        $request = $this->builder->fromPage(1)->withPageSize(10)->build();
        $result  = $this->useCase->execute($request);
        $this->assertInstanceOf(UserCollectionResponseDTO::class, $result);

        $this->assertEquals($request->getPage(), $result->getPage());
        $this->assertEquals($request->getPageSize(), $result->getPageSize());
        $this->assertEquals(2, $result->getTotal());
        $this->assertEquals(1, $result->pagesTotal());
        $this->assertInternalType('array', $result->getItems());
        list($user1, $user2) = $result->getItems();
        $this->assertInstanceOf(IUserResponse::class, $user1);
        $this->assertEquals(UserStub1::ID, $user1->getId());
        $this->assertEquals(UserStub2::ID, $user2->getId());

    }

    /**
     *
     */
    public function testLoadCollectionOutOfBounds()
    {
        $request = $this->builder->fromPage(10)->withPageSize(20)->build();
        $this->expectException(OutOfBounds::class);
        $this->useCase->execute($request);
    }


    /**
     *
     */
    protected function setUp()
    {
        $this->useCase = new GetUserCollection();
        $this->builder = new GetUserCollectionRequestBuilder();

        $this->useCase->setUserGateway(new InMemoryIUserGateway());
        $this->useCase->setCollectionResponseTransformer(
            new UserCollectionResponseTransformer()
        );
    }


}
