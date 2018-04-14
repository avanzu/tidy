<?php
/**
 * ActivateUserTest.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;


use Mockery\MockInterface;
use Tidy\Entities\User;
use Tidy\Gateways\IUserGateway;
use Tidy\Responders\User\IUserResponse;
use Tidy\Responders\User\IUserResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Entities\UserStub1;
use Tidy\UseCases\User\ActivateUser;
use Tidy\UseCases\User\DTO\ActivateUserRequestDTO;
use Tidy\UseCases\User\DTO\UserResponseTransformer;

class ActivateUserTest extends MockeryTestCase
{
    /**
     * @var ActivateUser
     */
    protected $useCase;
    /**
     * @var IUserGateway|MockInterface
     */
    protected $gateway;

    public function test_instantiation()
    {
        $this->assertInstanceOf(ActivateUser::class, $this->useCase);
    }

    public function test_activation()
    {
        $userId       = UserStub1::ID;
        $stub1        = new UserStub1();
        $argumentThat = argumentThat(
            function (User $user) {
                return ($user->isEnabled() === true);
            }
        );

        $this->expectFindAndSaveWith($userId, $stub1, $argumentThat);

        $request = ActivateUserRequestDTO::make();
        $request->withUserId(UserStub1::ID);

        $result = $this->useCase->execute($request);

        $this->assertInstanceOf(IUserResponse::class, $result);

        $this->assertTrue($result->isEnabled());
    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->gateway = mock(IUserGateway::class);

        $this->useCase = new ActivateUser($this->gateway, mock(IUserResponseTransformer::class));

        $this->useCase->setUserGateway($this->gateway);
        $this->useCase->setResponseTransformer(new UserResponseTransformer());


    }

    /**
     * @param $userId
     * @param $stub1
     * @param $argumentThat
     */
    private function expectFindAndSaveWith($userId, $stub1, $argumentThat): void
    {
        $this->gateway->expects('find')->with($userId)->andReturn($stub1);
        $this->gateway->expects('save')->with($argumentThat);
    }


}