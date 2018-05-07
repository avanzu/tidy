<?php
/**
 * RecoverTest.phpTidy
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Components\Util\StringUtilFactory;
use Tidy\Domain\BusinessRules\UserRules;
use Tidy\Domain\Collections\Users;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\User\IResponse;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\Domain\Responders\User\ItemResponder;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TimmyUser;
use Tidy\UseCases\User\DTO\RecoverRequestBuilder;
use Tidy\UseCases\User\Recover;

class RecoverTest extends MockeryTestCase
{
    /**
     * @var IUserGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var Recover
     */
    protected $useCase;


    public function test_instantiation()
    {
        $useCase = new Recover(mock(IUserGateway::class), mock(UserRules::class), mock(IResponseTransformer::class));
        assertThat($useCase, is(notNullValue()));
    }

    public function test_recover_success()
    {
        $request = (new RecoverRequestBuilder())->withUserName(TimmyUser::USERNAME)->build();

        $this->gateway->expects('findByUserName')->with(TimmyUser::USERNAME)->andReturn(new TimmyUser());
        $this->gateway->expects('save')->with(
            argumentThat(
                function (TimmyUser $user) {
                    return !empty($user->getToken());
                }
            )
        )
        ;

        $result = $this->useCase->execute($request);

        $this->assertInstanceOf(IResponse::class, $result);
        $this->assertEquals(TimmyUser::ID, $result->getId());
        $this->assertNotEmpty($result->getToken());
    }

    public function test_recover_failure()
    {
        $request = (new RecoverRequestBuilder())->withUserName('anonymous')->build();
        $this->gateway->expects('findByUserName')->with('anonymous')->andReturn(null);

        $this->expectException(NotFound::class);

        $this->useCase->execute($request);
    }

    protected function setUp()
    {
        $this->gateway = mock(IUserGateway::class);
        $this->useCase = new Recover($this->gateway, new UserRules(new StringUtilFactory(), new Users($this->gateway)));
    }


}