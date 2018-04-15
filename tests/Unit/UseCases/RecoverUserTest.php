<?php
/**
 * RecoverUserTest.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\UseCases;


use Mockery\MockInterface;
use Tidy\Exceptions\NotFound;
use Tidy\Gateways\IUserGateway;
use Tidy\Responders\User\IUserResponse;
use Tidy\Responders\User\IUserResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Entities\TimmyUser;
use Tidy\UseCases\User\DTO\RecoverUserRequestDTO;
use Tidy\UseCases\User\DTO\UserResponseTransformer;
use Tidy\UseCases\User\GenericUseCase;
use Tidy\UseCases\User\RecoverUser;

class RecoverUserTest extends MockeryTestCase
{
    /**
     * @var IUserGateway|MockInterface
     */
    protected $gateway;
    /**
     * @var RecoverUser
     */
    protected $useCase;


    public function test_instantiation()
    {
        $useCase = new RecoverUser(mock(IUserGateway::class), mock(IUserResponseTransformer::class));
        $this->assertInstanceOf(GenericUseCase::class, $useCase);
    }

    public function test_recover_success()
    {
        $request = RecoverUserRequestDTO::make();
        $request->withUserName(TimmyUser::USERNAME);

        $this->gateway->expects('findByUserName')->with(TimmyUser::USERNAME)->andReturn(new TimmyUser());
        $this->gateway->expects('save')->with(argumentThat(function(TimmyUser $user){
            return ! empty($user->getToken());
        }));


        $result = $this->useCase->execute($request);
        $this->assertInstanceOf(IUserResponse::class, $result);
        $this->assertEquals(TimmyUser::ID, $result->getId());
        $this->assertNotEmpty($result->getToken());
    }

    public function test_recover_failure()
    {
        $request = RecoverUserRequestDTO::make();
        $request->withUserName('anonymous');
        $this->gateway->expects('findByUserName')->with('anonymous')->andReturn(null);

        $this->expectException(NotFound::class);

        $this->useCase->execute($request);
    }

    protected function setUp()
    {
        $this->gateway = mock(IUserGateway::class);
        $this->useCase = new RecoverUser($this->gateway, new UserResponseTransformer());
    }


}