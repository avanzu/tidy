<?php
/**
 * LookUpTestphp
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;


use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\UserStub1;
use Tidy\UseCases\User\DTO\LookUpRequestDTO;
use Tidy\UseCases\User\DTO\ResponseDTO;
use Tidy\UseCases\User\DTO\ResponseTransformer;
use Tidy\UseCases\User\LookUp;

/**
 * Class LookUpTest
 */
class LookUpTest extends MockeryTestCase
{
    /**
     * @var \Tidy\Domain\Gateways\IUserGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var LookUp
     */
    private $useCase;

    /**
     *
     */
    public function testInstantiation()
    {
        $useCase = new LookUp(mock(IUserGateway::class));
        assertThat($useCase, is(notNullValue()));
        $this->assertInstanceOf(LookUp::class, $this->useCase);

        $useCase->setUserGateway($this->gateway);
        $useCase->setTransformer(new ResponseTransformer());
    }

    /**
     *
     */
    public function test_GetExistingUser_InvalidUserId_throws_UserNotFound()
    {
        $this->gateway->expects('find')->with(444)->andReturn(null);
        $request = LookUpRequestDTO::make()->withUserId(444);

        $this->expectException(NotFound::class);
        $this->useCase->execute($request);

    }

    /**
     *
     */
    public function test_GetExistingUser_ValidUserId_ReturnsUserResponse()
    {

        $this->gateway->expects('find')->with(UserStub1::ID)->andReturn(new UserStub1());
        $request = LookUpRequestDTO::make()->withUserId(UserStub1::ID);

        $response = $this->useCase->execute($request);
        $this->assertInstanceOf(ResponseDTO::class, $response);
        $this->assertEquals(UserStub1::ID, $response->getId());
        $this->assertEquals(UserStub1::USERNAME, $response->getUserName());

    }


    /**
     *
     */
    protected function setUp()
    {
        $this->gateway = mock(IUserGateway::class);
        $this->useCase = new LookUp($this->gateway);
    }


}
