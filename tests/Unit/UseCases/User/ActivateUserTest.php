<?php
/**
 * ActivateUserTest.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;


use Mockery\MockInterface;
use Tidy\Entities\User;
use Tidy\Exceptions\NotFound;
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

    public function test_activation_with_matching_token()
    {
        $stub1        = new UserStub1();
        $token        = uniqid();
        $stub1->setToken($token);

        $argumentThat = argumentThat(
            function (User $user) {
                return ($user->isEnabled() === true);
            }
        );

        $this->expectFindAndSaveWith($token, $stub1, $argumentThat);

        $request = ActivateUserRequestDTO::make();
        $request->withToken($token);

        $result = $this->useCase->execute($request);

        $this->assertInstanceOf(IUserResponse::class, $result);

        $this->assertTrue($result->isEnabled(), 'user should be enabled.');
        $this->assertEmpty($result->getToken(), 'token should be removed.');
    }

    public function test_activation_with_undefined_token()
    {
        $token = uniqid();
        $this->expectFindReturning($token, null);

        $this->expectException(NotFound::class);
        $this->useCase->execute(ActivateUserRequestDTO::make()->withToken($token));

    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->gateway = mock(IUserGateway::class);

        $this->useCase = new ActivateUser($this->gateway, mock(IUserResponseTransformer::class));

        $this->useCase->setUserGateway($this->gateway);
        $this->useCase->setResponseTransformer(new UserResponseTransformer());


    }

    /**
     * @param $token
     * @param $stub1
     * @param $argumentThat
     */
    private function expectFindAndSaveWith($token, $stub1, $argumentThat)
    {
        $this->expectFindReturning($token, $stub1);
        $this->gateway->expects('save')->with($argumentThat);
    }

    /**
     * @param $token
     * @param $stub1
     */
    private function expectFindReturning($token, $stub1)
    {
        $this->gateway->expects('findByToken')->with($token)->andReturn($stub1);
    }


}