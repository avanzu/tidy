<?php
/**
 * ActivateTest.phpTidy
 * Date: 14.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use Mockery\MockInterface;
use Tidy\Components\Audit\Change;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Entities\User;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\Audit\ChangeResponse;
use Tidy\Domain\Responders\Audit\ChangeResponseTransformer;
use Tidy\Domain\Responders\Audit\IChangeResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\UserStub1;
use Tidy\UseCases\User\Activate;
use Tidy\UseCases\User\DTO\ActivateRequestDTO;

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
        $useCase = new Activate($this->gateway, mock(IChangeResponseTransformer::class));
        $this->assertInstanceOf(Activate::class, $useCase);
        $useCase->setTransformer(new ChangeResponseTransformer());
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

        assertThat($result, is(anInstanceOf(ChangeResponse::class)));

        $expected = [
            [
                'op'    => Change::OP_REPLACE,
                'path'  => 'enabled',
                'value' => true,
            ],
            [
                'op'   => Change::OP_REMOVE,
                'path' => 'token',
            ],
        ];
        assertThat($result->changes(), is(equalTo($expected)));
        /*
        $this->assertInstanceOf(IResponse::class, $result);

        $this->assertTrue($result->isEnabled(), 'user should be enabled.');
        $this->assertEmpty($result->getToken(), 'token should be removed.');
        */
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
        $this->useCase = new Activate($this->gateway);
        $this->useCase->setUserGateway($this->gateway);

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