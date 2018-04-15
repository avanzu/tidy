<?php
/**
 * GetUserCollectionTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\OutOfBounds;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\User\IUserResponse;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\UserStub1;
use Tidy\Tests\Unit\Domain\Entities\UserStub2;
use Tidy\UseCases\User\DTO\GetUserCollectionRequestDTO;
use Tidy\UseCases\User\DTO\UserCollectionResponseDTO;
use Tidy\UseCases\User\DTO\UserCollectionResponseTransformer;
use Tidy\UseCases\User\GetUserCollection;

/**
 * Class GetUserCollectionTest
 */
class GetUserCollectionTest extends MockeryTestCase
{
    /**
     * @var \Tidy\Domain\Gateways\IUserGateway|MockInterface
     */
    protected $gateway;
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
        $this->setupFetchCollection(new UserStub1());

        $request = GetUserCollectionRequestDTO::make()->fromPage(1)->withPageSize(10);

        $result = $this->useCase->execute($request);
        $this->assertInstanceOf(UserCollectionResponseDTO::class, $result);

    }

    /**
     */
    public function test_UserCollectionResponse_containsValidBoundaries()
    {
        $this->setupFetchCollection(new UserStub1());

        $request = GetUserCollectionRequestDTO::make()->fromPage(1)->withPageSize(10);

        $result = $this->useCase->execute($request);

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


        $this->setupFetchCollection(new UserStub1(), new UserStub2());

        $request = GetUserCollectionRequestDTO::make()->fromPage(1)->withPageSize(10);

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
        $this->gateway->shouldReceive('fetchCollection')->andThrow(new OutOfBounds());

        $request = GetUserCollectionRequestDTO::make()->fromPage(10)->withPageSize(20);
        $this->expectException(OutOfBounds::class);
        $this->useCase->execute($request);
    }

    /**
     *
     */
    protected function setUp()
    {
        $this->useCase = new GetUserCollection();
        $this->gateway = mock(IUserGateway::class);

        $this->useCase->setUserGateway($this->gateway);
        $this->useCase->setResponseTransformer(
            new UserCollectionResponseTransformer()
        );
    }

    private function setupFetchCollection(...$elements)
    {
        $this->gateway->expects('fetchCollection')->andReturn($elements);
        $this->gateway->expects('getTotal')->andReturn(count($elements));

    }


}
