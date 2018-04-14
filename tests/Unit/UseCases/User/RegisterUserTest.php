<?php
/**
 * RegisterUserTest.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;


use Mockery\MockInterface;
use Tidy\Gateways\IUserGateway;
use Tidy\Responders\User\IUserResponse;
use Tidy\Tests\MockeryTestCase;
use Tidy\UseCases\User\DTO\RegisterUserRequestDTO;
use Tidy\UseCases\User\DTO\UserResponseTransformer;
use Tidy\UseCases\User\RegisterUser;

class RegisterUserTest extends MockeryTestCase
{

    /**
     * @var RegisterUser
     */
    protected $useCase;

    /**
     * @var MockInterface|IUserGateway
     */
    private $gateway;

    public function test_instantiation()
    {
        $useCase = new RegisterUser();
        $this->assertInstanceOf(RegisterUser::class, $useCase);
    }

    public function test_RegisterUser()
    {
        $request = RegisterUserRequestDTO::make();
        $request
            ->withUserName('timmy')
            ->withEMail('timmy@example.com')
            ->withPlainPassword('123999');

        $result = $this->useCase->execute($request);
        $this->assertInstanceOf(IUserResponse::class, $result);
    }

    protected function setUp()
    {
        $this->useCase = new RegisterUser();
        $this->gateway    = mock(IUserGateway::class);
        $this->useCase->setUserGateway($this->gateway);
        $this->useCase->setResponseTransformer(new UserResponseTransformer());
    }


}