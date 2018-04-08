<?php
/**
 * GetUserTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;


use PHPUnit\Framework\TestCase;
use Tidy\Exceptions\NotFound;

use Tidy\Tests\Unit\Entities\UserStub1;
use Tidy\Tests\Unit\Entities\UserStub2;
use Tidy\Tests\Unit\Gateways\InMemoryUserGateway;
use Tidy\UseCases\User\DTO\GetUserRequestDTO;
use Tidy\UseCases\User\DTO\UserResponseDTO;
use Tidy\UseCases\User\DTO\UserResponseTransformer;
use Tidy\UseCases\User\GetUser;

/**
 * Class GetUserTest
 */
class GetUserTest extends TestCase
{

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
    public function testUserNotFound()
    {

        $request = GetUserRequestDTO::create()->withUserId(444);
        $this->expectException(NotFound::class);
        $this->useCase->execute($request);

    }

    /**
     *
     */
    public function testGetExistingUser()
    {
        InMemoryUserGateway::$users = [UserStub1::ID => new UserStub1(), UserStub2::ID => new UserStub2()];

        $request  = GetUserRequestDTO::create()->withUserId(123);
        $response = $this->useCase->execute($request);
        $this->assertInstanceOf(UserResponseDTO::class, $response);
        $this->assertEquals(UserStub1::ID, $response->getId());
        $this->assertEquals(UserStub1::USERNAME, $response->getUserName());


        $request  = GetUserRequestDTO::create()->withUserId(999);
        $response = $this->useCase->execute($request);
        $this->assertEquals(UserStub2::ID, $response->getId());
        $this->assertEquals(UserStub2::USERNAME, $response->getUserName());
    }


    /**
     *
     */
    protected function setUp()
    {
        $this->useCase = new GetUser();

        $this->useCase->setUserGateway(new InMemoryUserGateway());
        $this->useCase->setResponseTransformer(new UserResponseTransformer());
    }


}
