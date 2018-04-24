<?php
/**
 * RecoverTest.phpTidy
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use Mockery\MockInterface;
use Tidy\Components\Audit\Change;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\Audit\ChangeResponse;
use Tidy\Domain\Responders\Audit\IChangeResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TimmyUser;
use Tidy\UseCases\User\DTO\RecoverRequestDTO;
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
        $useCase = new Recover(mock(IUserGateway::class), mock(IChangeResponseTransformer::class));
        $this->assertInstanceOf(\Tidy\Domain\Responders\User\ChangeResponder::class, $useCase);
    }

    public function test_recover_success()
    {
        $request = RecoverRequestDTO::make();
        $request->withUserName(TimmyUser::USERNAME);

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

        $expected = [
            ['op' => Change::OP_ADD, 'path' => 'token']
        ];
        assertThat($result, is(anInstanceOf(ChangeResponse::class)));
        $this->assertArraySubset($expected, $result->changes());

        /*
        $this->assertInstanceOf(IResponse::class, $result);
        $this->assertEquals(TimmyUser::ID, $result->getId());
        $this->assertNotEmpty($result->getToken());
        */
    }

    public function test_recover_failure()
    {
        $request = RecoverRequestDTO::make();
        $request->withUserName('anonymous');
        $this->gateway->expects('findByUserName')->with('anonymous')->andReturn(null);

        $this->expectException(NotFound::class);

        $this->useCase->execute($request);
    }

    protected function setUp()
    {
        $this->gateway = mock(IUserGateway::class);
        $this->useCase = new Recover($this->gateway);
    }


}