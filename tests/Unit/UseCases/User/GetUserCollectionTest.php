<?php
/**
 * GetUserCollectionTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use PHPUnit\Framework\TestCase;
use Tidy\Exceptions\OutOfBounds;
use Tidy\Responders\User\IUserResponse;
use Tidy\Tests\Unit\Entities\UserStub1;
use Tidy\Tests\Unit\Entities\UserStub2;
use Tidy\Tests\Unit\Gateways\InMemoryUserGateway;
use Tidy\UseCases\User\DTO\GetUserCollectionRequestDTO;
use Tidy\UseCases\User\DTO\UserCollectionResponseDTO;
use Tidy\UseCases\User\DTO\UserCollectionResponseTransformer;
use Tidy\UseCases\User\GetUserCollection;

/**
 * Class GetUserCollectionTest
 */
class GetUserCollectionTest extends TestCase
{
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


    public function test_GetUserCollectionRequest_returnsUserCollectionResponse()
    {
        $request = GetUserCollectionRequestDTO::create()->fromPage(1)->withPageSize(10);

        $result = $this->useCase->execute($request);
        $this->assertInstanceOf(UserCollectionResponseDTO::class, $result);

    }
    /**
     */
    public function test_UserCollectionResponse_containsValidBoundaries()
    {

        InMemoryUserGateway::$users = [
            UserStub1::ID => new UserStub1(),
        ];

        $request = GetUserCollectionRequestDTO::create()->fromPage(1)->withPageSize(10);
        $result  = $this->useCase->execute($request);

        $this->assertEquals($request->getPage(), $result->getPage());
        $this->assertEquals($request->getPageSize(), $result->getPageSize());
        $this->assertEquals(1, $result->getTotal());
        $this->assertEquals(1, $result->pagesTotal());

    }

    /**
     *
     */
    public function test_UserCollectionResponse_ContainsUserResponseItems()
    {


        InMemoryUserGateway::$users = [
            UserStub1::ID => new UserStub1(),
            UserStub2::ID => new UserStub2(),
        ];

        $request = GetUserCollectionRequestDTO::create()->fromPage(1)->withPageSize(10);

        $result = $this->useCase->execute($request);

        $this->assertInternalType('array', $result->getItems());

        list($user1, $user2) = $result->getItems();
        $this->assertInstanceOf(IUserResponse::class, $user1);
        $this->assertEquals(UserStub1::ID, $user1->getId());
        $this->assertEquals(UserStub2::ID, $user2->getId());

    }

    /**
     *
     */
    public function test_GetUserCollectionRequest_WithExceedingPage_throwsOutOfBounds()
    {
        $request = GetUserCollectionRequestDTO::create()->fromPage(10)->withPageSize(20);
        $this->expectException(OutOfBounds::class);
        $this->useCase->execute($request);
    }




    /**
     *
     */
    protected function setUp()
    {
        $this->useCase = new GetUserCollection();

        $this->useCase->setUserGateway(new InMemoryUserGateway());
        $this->useCase->setResponseTransformer(
            new UserCollectionResponseTransformer()
        );
    }





}
