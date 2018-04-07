<?php
/**
 * GetUserTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;


use Tidy\Tests\Unit\Gateways\InMemoryUserGateway;
use PHPUnit\Framework\TestCase;
use Tidy\Exceptions\NotFound;
use Tidy\Tests\Unit\Entities\UserStub1;
use Tidy\Tests\Unit\Entities\UserStub2;
use Tidy\UseCases\User\DTO\GetUserRequestBuilder;
use Tidy\UseCases\User\DTO\UserResponseDTO;
use Tidy\UseCases\User\DTO\UserResponseTransformer;
use Tidy\UseCases\User\GetUser;

class GetUserTest extends TestCase
{
    /**
     * @var \Tidy\Requestors\User\GetUserRequestBuilder
     */
    private  $requestBuilder;

    /**
     * @var GetUser
     */
    private $useCase;

    public function testInstantiation()
    {
        $this->assertInstanceOf(GetUser::class, $this->useCase);
    }

    public function testUserNotFound()
    {
        $request = $this->requestBuilder->withUserId(444)->build();
        $this->expectException(NotFound::class);
        $this->useCase->execute($request);

    }

    public function testGetExistingUser()
    {
        InMemoryUserGateway::$users = [UserStub1::ID => new UserStub1(), UserStub2::ID => new UserStub2()];

        $request = $this->requestBuilder->withUserId(123)->build();

        $response = $this->useCase->execute($request);
        $this->assertInstanceOf(UserResponseDTO::class, $response);
        $this->assertEquals(UserStub1::ID, $response->getId());
        $this->assertEquals(UserStub1::USERNAME, $response->getUserName());


        $request = $this->requestBuilder->withUserId(999)->build();
        $response = $this->useCase->execute($request);
        $this->assertEquals(UserStub2::ID, $response->getId());
        $this->assertEquals(UserStub2::USERNAME, $response->getUserName());
    }



    protected function setUp()
    {
        $this->useCase        = new GetUser();
        $this->requestBuilder = new GetUserRequestBuilder();

        $this->useCase->setUserGateway(new InMemoryUserGateway());
        $this->useCase->setResponseTransformer(new UserResponseTransformer());
    }


}
