<?php
/**
 * GetUserTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;


use Mockery\MockInterface;
use Tidy\Exceptions\NotFound;
use Tidy\Gateways\IUserGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Entities\UserStub1;
use Tidy\UseCases\User\DTO\GetUserRequestDTO;
use Tidy\UseCases\User\DTO\UserResponseDTO;
use Tidy\UseCases\User\DTO\UserResponseTransformer;
use Tidy\UseCases\User\GetUser;

/**
 * Class GetUserTest
 */
class GetUserTest extends MockeryTestCase
{
    /**
     * @var IUserGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var GetUser
     */
    private $useCase;

    /**
     *
     */
    public function testInstantiation()
    {
        $this->assertInstanceOf(GetUser::class, $this->useCase);
    }

    /**
     *
     */
    public function test_GetExistingUser_InvalidUserId_throws_UserNotFound()
    {
        $this->gateway->expects('find')->with(444)->andThrow(new NotFound());
        $request = GetUserRequestDTO::create()->withUserId(444);

        $this->expectException(NotFound::class);
        $this->useCase->execute($request);

    }

    /**
     *
     */
    public function test_GetExistingUser_ValidUserId_ReturnsUserResponse()
    {

        $this->gateway->expects('find')->with(UserStub1::ID)->andReturn(new UserStub1());
        $request = GetUserRequestDTO::create()->withUserId(UserStub1::ID);

        $response = $this->useCase->execute($request);
        $this->assertInstanceOf(UserResponseDTO::class, $response);
        $this->assertEquals(UserStub1::ID, $response->getId());
        $this->assertEquals(UserStub1::USERNAME, $response->getUserName());

    }


    /**
     *
     */
    protected function setUp()
    {
        $this->useCase = new GetUser();
        $this->gateway = mock(IUserGateway::class);
        $this->useCase->setUserGateway($this->gateway);
        $this->useCase->setResponseTransformer(new UserResponseTransformer());
    }


}
