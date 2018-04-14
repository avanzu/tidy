<?php
/**
 * CreateUserTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Tidy\Entities\User;
use Tidy\Exceptions\PersistenceFailed;
use Tidy\Gateways\IUserGateway;
use Tidy\Tests\Unit\Entities\UserImpl;
use Tidy\Tests\Unit\Gateways\InMemoryUserGateway;
use Tidy\UseCases\User\CreateUser;
use Tidy\UseCases\User\DTO\CreateUserRequestDTO;
use Tidy\UseCases\User\DTO\UserResponseDTO;
use Tidy\UseCases\User\DTO\UserResponseTransformer;

class CreateUserTest extends TestCase
{
    /**
     * @var IUserGateway|MockInterface
     */
    protected $gateway;
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
        $this->gateway->expects('save')->with(argumentThat(function(User $user) use ($username){
            return $user->getUserName() ===  $username;
        }))
        ->andReturnUsing(function(User $user){
            return identify($user, 999);
        })
        ;


        $request  = CreateUserRequestDTO::create()->withUserName($username);


        $result   = $this->useCase->execute($request);
        $this->assertInstanceOf(UserResponseDTO::class, $result);
        $this->assertEquals($username, $result->getUserName());
        $this->assertEquals(999, $result->getId());
    }


    public function test_CreateUserRequest_persistenceFailure_throwsPersistenceFailed()
    {
        $this->gateway->expects('save')->andThrows(new PersistenceFailed());

        $this->expectException(PersistenceFailed::class);
        $this->useCase->execute(CreateUserRequestDTO::create());


    }


    protected function setUp()
    {
        $this->useCase = new CreateUser();
        $this->gateway = mock(IUserGateway::class);
        $this->gateway->allows('produce')->andReturn(new UserImpl());

        $this->useCase->setUserGateway($this->gateway);
        $this->useCase->setResponseTransformer(new UserResponseTransformer());

    }


}
