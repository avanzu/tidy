<?php
/**
 * ResetPasswordTest.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Components\Validation\IPasswordStrengthValidator;
use Tidy\Components\Validation\Validators\PasswordStrengthValidator;
use Tidy\Domain\Entities\User;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\User\IResponse;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\UserStub2;
use Tidy\UseCases\User\DTO\ResetPasswordRequestBuilder;
use Tidy\UseCases\User\ResetPassword;

class ResetPasswordTest extends MockeryTestCase
{

    const RESET_TOKEN   = 'reset-token';
    const PLAIN_PASS    = '/bb|[^B]{2}/';
    const INVALID_TOKEN = 'invalid-token';

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
    /**
     * @var IStringUtilFactory|MockInterface
     */
    protected $factory;

    public function test_instantiation()
    {
        $useCase = new ResetPassword(mock(IStringUtilFactory::class), $this->gateway, mock(IResponseTransformer::class));
        $this->assertInstanceOf(ResetPassword::class, $useCase);
    }

    public function test_reset_success()
    {
        $hash = password_hash(self::PLAIN_PASS, PASSWORD_BCRYPT);

        $request = (new ResetPasswordRequestBuilder())
            ->withToken(self::RESET_TOKEN)
            ->withPlainPassword(self::PLAIN_PASS)
            ->build();

        $this->expectFindByToken(self::RESET_TOKEN, new UserStub2(self::RESET_TOKEN));

        $this->expectPasswordStrengthCheck();
        $this->expectEncoderFactoryCall();
        $this->expectEncode($hash);
        $this->expectSaveWithEncodedPassword($hash);

        $result = $this->useCase->execute($request);

        $this->assertInstanceOf(IResponse::class, $result);
        $this->assertEquals(UserStub2::ID, $result->getId(), 'User should match.');
        $this->assertEquals($hash, $result->getPassword(), 'Password should be the new hash.');
        $this->assertEmpty($result->getToken(), 'Token should be cleared.');
    }

    public function test_reset_verifies_password_strength() {

        $request = (new ResetPasswordRequestBuilder())
            ->withToken(self::RESET_TOKEN)
            ->withPlainPassword("123")
            ->build();

        $this->expectFindByToken(self::RESET_TOKEN, new UserStub2(self::RESET_TOKEN));
        $this->expectPasswordStrengthCheck();

        try {
            $this->useCase->execute($request);
            $this->fail('Failed to fail.');
        } catch(PreconditionFailed $exception){
            $this->assertStringStartsWith('Password is too weak', $exception->atIndex('plainPassword'));
        }
    }

    public function test_reset_verifies_token() {
        $request = (new ResetPasswordRequestBuilder())
            ->withToken(self::RESET_TOKEN)
            ->withPlainPassword("123")
            ->build();

        $this->expectFindByToken(self::RESET_TOKEN, new UserStub2(self::INVALID_TOKEN));
        $this->expectPasswordStrengthCheck();

        try {
            $this->useCase->execute($request);
            $this->fail('Failed to fail.');
        } catch(PreconditionFailed $exception){
            $this->assertStringMatchesFormat('Token "%s" does not match expected "%s".', $exception->atIndex('token'));
        }
    }

    public function test_reset_failure()
    {

        $request = (new ResetPasswordRequestBuilder())
            ->withToken(self::INVALID_TOKEN)
            ->withPlainPassword(self::PLAIN_PASS)
            ->build();

        $this->expectFindByToken(self::INVALID_TOKEN, null);
        $this->expectException(NotFound::class);

        $this->useCase->execute($request);

    }

    protected function setUp()
    {
        $this->gateway = mock(IUserGateway::class);
        $this->encoder = mock(IPasswordEncoder::class);
        $this->factory = mock(IStringUtilFactory::class);
        $this->useCase = new ResetPassword($this->factory, $this->gateway);

    }

    protected function expectPasswordStrengthCheck(
        $passwordStrengthValidator = null,
        $passwordStrength = IPasswordStrengthValidator::STRENGTH_STRONG
    ) {
        $passwordStrengthValidator = $passwordStrengthValidator ?: new PasswordStrengthValidator($passwordStrength);
        $this->factory
            ->expects('createPasswordStrengthValidator')
            ->with($passwordStrength)
            ->andReturn($passwordStrengthValidator)
        ;
    }

    protected function expectEncoderFactoryCall() {
        $this->factory->allows('createEncoder')->andReturn($this->encoder);
    }

    private function expectFindByToken($str, $returnValue)
    {
        $this->gateway->expects('findByToken')->with($str)->andReturn($returnValue);
    }

    /**
     * @param $hash
     */
    private function expectEncode($hash)
    {
        $this->encoder->expects('encode')->with(self::PLAIN_PASS, null)->andReturn($hash);
    }

    /**
     * @param $hash
     */
    private function expectSaveWithEncodedPassword($hash)
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