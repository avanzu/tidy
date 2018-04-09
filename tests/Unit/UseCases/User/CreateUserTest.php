<?php
/**
 * CreateUserTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use PHPUnit\Framework\TestCase;
use Tidy\Exceptions\PersistenceFailed;
use Tidy\Tests\Unit\Gateways\InMemoryUserGateway;
use Tidy\UseCases\User\CreateUser;
use Tidy\UseCases\User\DTO\CreateUserRequestDTO;
use Tidy\UseCases\User\DTO\UserResponseDTO;
use Tidy\UseCases\User\DTO\UserResponseTransformer;

class CreateUserTest extends TestCase
{
    /**
     * @var CreateUser
     */
    private $useCase;

    public function testInstantiation()
    {
        $this->assertInstanceOf(CreateUser::class, $this->useCase);

    }

    public function test_CreateUserRequest_returnsUserResponse()
    {
        $username = 'Timmy';
        $request  = CreateUserRequestDTO::create()->withUserName($username);
        $result   = $this->useCase->execute($request);
        $this->assertInstanceOf(UserResponseDTO::class, $result);
        $this->assertEquals($username, $result->getUserName());
        $this->assertNotNull($result->getId());
    }


    public function test_CreateUserRequest_persistenceFailure_throwsPersistenceFailed()
    {
        $gateway = $this->createPartialMock(InMemoryUserGateway::class, ['save']);
        $gateway->method('save')->willThrowException(new PersistenceFailed());
        $this->useCase->setUserGateway($gateway);
        $this->expectException(PersistenceFailed::class);
        $this->useCase->execute(CreateUserRequestDTO::create());


    }


    protected function setUp()
    {
        $this->useCase = new CreateUser();
        $this->useCase->setUserGateway(new InMemoryUserGateway());
        $this->useCase->setResponseTransformer(new UserResponseTransformer());

    }


}
