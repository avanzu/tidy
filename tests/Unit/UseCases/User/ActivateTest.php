<?php
/**
 * ActivateTest.phpTidy
 * Date: 14.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Components\Util\StringUtilFactory;
use Tidy\Domain\BusinessRules\UserRules;
use Tidy\Domain\Collections\Users;
use Tidy\Domain\Entities\User;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\User\IResponse;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TimmyUser;
use Tidy\Tests\Unit\Fixtures\Entities\UserStub1;
use Tidy\UseCases\User\Activate;
use Tidy\UseCases\User\DTO\ActivateRequestBuilder;
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

    /**
     * @var  UserRules|MockInterface
     */
    private   $userRules;

    public function test_instantiation()
    {
        $useCase = new Activate($this->gateway, mock(UserRules::class), mock(IResponseTransformer::class));
        $this->assertInstanceOf(Activate::class, $useCase);
        $useCase->setTransformer(new ResponseTransformer());
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

        $request = (new ActivateRequestBuilder())->withToken($token)->build();
        /*
        ActivateRequestDTO::make();
        $request->withToken($token);
        */
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
        $this->useCase->execute((new ActivateRequestBuilder())->withToken($token)->build());
    }

    public function test_activate_with_token_mismatch()
    {
        $token = uniqid();
        $user  = new TimmyUser();
        $user->assignToken(uniqid());
        $this->expectFindReturning($token, $user);

        try {
            $this->useCase->execute((new ActivateRequestBuilder())->withToken($token)->build());
            $this->fail('Failed to fail.');
        } catch (PreconditionFailed $exception) {
            $this->assertStringMatchesFormat('Token "%s" does not match expected "%s".', $exception->atIndex('token'));
        }
    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->gateway   = mock(IUserGateway::class);
        $this->userRules = new UserRules(new StringUtilFactory(), new Users($this->gateway));

        $this->useCase = new Activate($this->gateway, $this->userRules);
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