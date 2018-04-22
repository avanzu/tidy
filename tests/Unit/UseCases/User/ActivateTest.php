<?php
/**
 * ActivateTest.phpTidy
 * Date: 14.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;


use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Entities\User;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\User\IResponse;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\UserStub1;
use Tidy\UseCases\User\Activate;
use Tidy\UseCases\User\DTO\ActivateRequestDTO;
use Tidy\UseCases\User\DTO\ResponseTransformer;

class ActivateTest extends MockeryTestCase
{
    /**
     * @var Activate
     */
    protected $useCase;
    /**
     * @var IUserGateway|MockInterface
     */
    protected $gateway;

    public function test_instantiation()
    {
        $this->assertInstanceOf(Activate::class, $this->useCase);
    }

    public function test_activation_with_matching_token()
    {
        $stub1 = new UserStub1();
        $token = uniqid();
        $stub1->assignToken($token);

        $argumentThat = argumentThat(
            function (User $user) {
                return ($user->isEnabled() === true);
            }
        );

        $this->expectFindAndSaveWith($token, $stub1, $argumentThat);

        $request = ActivateRequestDTO::make();
        $request->withToken($token);

        $result = $this->useCase->execute($request);

        $this->assertInstanceOf(IResponse::class, $result);

        $this->assertTrue($result->isEnabled(), 'user should be enabled.');
        $this->assertEmpty($result->getToken(), 'token should be removed.');
    }

    public function test_activation_with_undefined_token()
    {
        $token = uniqid();
        $this->expectFindReturning($token, null);

        $this->expectException(NotFound::class);
        $this->useCase->execute(ActivateRequestDTO::make()->withToken($token));

    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->gateway = mock(IUserGateway::class);

        $this->useCase = new Activate($this->gateway, mock(IResponseTransformer::class));

        $this->useCase->setUserGateway($this->gateway);
        $this->useCase->setResponseTransformer(new ResponseTransformer());


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