<?php
/**
 * ResetPasswordTest.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;


use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Domain\Entities\User;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\User\IUserResponse;
use Tidy\Domain\Responders\User\IUserResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\UserStub2;
use Tidy\UseCases\User\DTO\ResetPasswordRequestDTO;
use Tidy\UseCases\User\DTO\UserResponseTransformer;
use Tidy\UseCases\User\ResetPassword;

class ResetPasswordTest extends MockeryTestCase
{

    /**
     * @var \Tidy\Domain\Gateways\IUserGateway|MockInterface
     */
    protected $gateway;
    /**
     * @var ResetPassword
     */
    protected $useCase;
    /**
     * @var IPasswordEncoder|MockInterface
     */
    protected $encoder;

    const RESET_TOKEN = 'reset-token';

    const PLAIN_PASS = '123123';

    const INVALID_TOKEN = 'invalid-token';

    public function test_instantiation()
    {
        $useCase = new ResetPassword($this->encoder, $this->gateway, mock(IUserResponseTransformer::class));
        $this->assertInstanceOf(ResetPassword::class, $useCase);
    }

    public function test_reset_success()
    {
        $hash = password_hash(self::PLAIN_PASS, PASSWORD_BCRYPT);

        $request = ResetPasswordRequestDTO::make();
        $request->withToken(self::RESET_TOKEN)->withPlainPassword(self::PLAIN_PASS);

        $this->expectFindByToken(self::RESET_TOKEN, new UserStub2());
        $this->expectEncode($hash);
        $this->expectSaveWithEncodedPassword($hash);

        $result  = $this->useCase->execute($request);

        $this->assertInstanceOf(IUserResponse::class, $result);
        $this->assertEquals(UserStub2::ID, $result->getId(), 'User should match.');
        $this->assertEquals($hash, $result->getPassword(), 'Password should be the new hash.');
        $this->assertEmpty($result->getToken(), 'Token should be cleared.');
    }


    public function test_reset_failure()
    {
        $request = ResetPasswordRequestDTO::make();
        $request->withToken(self::INVALID_TOKEN)->withPlainPassword(self::PLAIN_PASS);

        $this->expectFindByToken(self::INVALID_TOKEN, null);
        $this->expectException(NotFound::class);

        $this->useCase->execute($request);

    }

    protected function setUp()
    {
        $this->gateway = mock(IUserGateway::class);
        $this->encoder = mock(IPasswordEncoder::class);
        $this->useCase = new ResetPassword($this->encoder, $this->gateway, new UserResponseTransformer());


    }

    private function expectFindByToken($str, $returnValue): void
    {
        $this->gateway->expects('findByToken')->with($str)->andReturn($returnValue);
    }

    /**
     * @param $hash
     */
    private function expectEncode($hash): void
    {
        $this->encoder->expects('encode')->with(self::PLAIN_PASS, null)->andReturn($hash);
    }

    /**
     * @param $hash
     */
    private function expectSaveWithEncodedPassword($hash): void
    {
        $this->gateway->expects('save')->with(
            argumentThat(
                function (User $user) use ($hash) {
                    if ($user->getPassword() === $hash) {
                        return true;
                    }

                    return empty($user->getToken());
                }
            )
        )
        ;
    }


}