<?php
/**
 * GetCatalogueCollectionTest
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use Mockery\MockInterface;
use Tidy\Components\Collection\Boundary;
use Tidy\Components\DataAccess\Comparison;
use Tidy\Components\Exceptions\OutOfBounds;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Requestors\CollectionRequest;
use Tidy\Domain\Requestors\CollectionRequestBuilder;
use Tidy\Domain\Responders\User\ICollectionResponse;
use Tidy\Domain\Responders\User\IResponse;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\UserStub1;
use Tidy\Tests\Unit\Fixtures\Entities\UserStub2;
use Tidy\UseCases\User\DTO\CollectionResponseDTO;
use Tidy\UseCases\User\DTO\CollectionResponseTransformer;
use Tidy\UseCases\User\DTO\GetCollectionRequestDTO;
use Tidy\UseCases\User\GetCollection;

/**
 * Class GetCatalogueCollectionTest
 */
class GetCollectionTest extends MockeryTestCase
{
    /**
     * @var \Tidy\Domain\Gateways\IUserGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var GetCollection
     */
    private $useCase;

    /**
     *
     */
    public function testInstantiation()
    {
        $this->assertInstanceOf(GetCollection::class, $this->useCase);
        $this->useCase->setUserGateway($this->gateway);
        $this->useCase->setResponseTransformer(
            new CollectionResponseTransformer()
        );
    }


    public function test_GetUserCollectionRequest_returnsUserCollectionResponse()
    {
        $this->setupFetchCollection(new UserStub1());

        $request = (new CollectionRequestBuilder())->fromPage(1)->withPageSize(10)->build();

        $result = $this->useCase->execute($request);
        $this->assertInstanceOf(CollectionResponseDTO::class, $result);

    }

    /**
     */
    public function test_UserCollectionResponse_containsValidBoundaries()
    {
        $this->setupFetchCollection(new UserStub1());

        $request = (new CollectionRequestBuilder())->fromPage(1)->withPageSize(10)->build();

        $result = $this->useCase->execute($request);

        $this->assertEquals($request->page(), $result->currentPage());
        $this->assertEquals($request->pageSize(), $result->pageSize());
        $this->assertEquals(1, $result->total());
        $this->assertEquals(1, $result->pagesTotal());

    }

    /**
     *
     */
    public function test_UserCollectionResponse_ContainsUserResponseItems()
    {

        $this->setupFetchCollection(new UserStub1(), new UserStub2());

        $request = (new CollectionRequestBuilder())->fromPage(1)->withPageSize(10)->build();

        $result = $this->useCase->execute($request);

        $this->assertInternalType('array', $result->getItems());

        list($user1, $user2) = $result->getItems();
        $this->assertInstanceOf(IResponse::class, $user1);
        $this->assertEquals(UserStub1::ID, $user1->getId());
        $this->assertEquals(UserStub2::ID, $user2->getId());

    }

    /**
     *
     */
    public function test_GetUserCollectionRequest_WithExceedingPage_throwsOutOfBounds()
    {
        $this->gateway->shouldReceive('fetchCollection')->andThrow(new OutOfBounds());

        $request = (new CollectionRequestBuilder())->fromPage(10)->withPageSize(20)->build();
        $this->expectException(OutOfBounds::class);
        $this->useCase->execute($request);
    }

    public function test_GetUserCollection_WithComparison()
    {

        $page     = CollectionRequest::DEFAULT_PAGE;
        $pageSize = CollectionRequest::DEFAULT_PAGE_SIZE;

        $request =
            (new CollectionRequestBuilder())
            ->fromPage($page)
            ->withPageSize($pageSize)
            ->withUserName(Comparison::equalTo('some username'))
            ->withEMail(Comparison::containing('example.com'))
            ->withAccess(Comparison::isTrue())
            ->withToken(Comparison::isEmpty())
            ->withLastName(Comparison::startsWith('Tim'))
            ->withFirstName(Comparison::endsWith('my'))
            ->build()
        ;

        $criteriaCheck = function ($argument) {
            if (count($argument) != 6) {
                return false;
            }

            return count(array_filter($argument, function ($item) { return !($item instanceof Comparison); })) === 0;
        };

        $this->gateway->expects('fetchCollection')
                      ->with(anInstanceOf(Boundary::class), argumentThat($criteriaCheck))
                      ->andReturn([new UserStub1(), new UserStub2()])
                      ->byDefault()
        ;

        $this->gateway
            ->expects('total')
            ->with($request->criteria())
            ->andReturn(2)
        ;

        $result = $this->useCase->execute($request);
        $this->assertInstanceOf(ICollectionResponse::class, $result);

    }

    /**
     *
     */
    protected function setUp()
    {
        $this->gateway = mock(IUserGateway::class);
        $this->useCase = new GetCollection($this->gateway);
    }

    private function setupFetchCollection(...$elements)
    {
        $this->gateway->expects('fetchCollection')->andReturn($elements);
        $this->gateway->expects('total')->andReturn(count($elements));

    }


}
