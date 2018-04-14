<?php
/**
 * CreateUserTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Entities\User;
use Tidy\Exceptions\PersistenceFailed;
use Tidy\Gateways\IUserGateway;
use Tidy\Tests\Unit\Entities\UserImpl;
use Tidy\UseCases\User\CreateUser;
use Tidy\UseCases\User\DTO\CreateUserRequestDTO;
use Tidy\UseCases\User\DTO\ICreateUserRequest;
use Tidy\UseCases\User\DTO\UserResponseDTO;
use Tidy\UseCases\User\DTO\UserResponseTransformer;

class CreateUserTest extends TestCase
{
    const TIMMY      = 'Timmy';
    const PLAIN_PASS = '123999';
    const TIMMY_MAIL = 'timmy@example.com';
    /**
     * @var IUserGateway|MockInterface
     */
    protected $gateway;
    /**
     * @var IPasswordEncoder|MockInterface
     */
    protected $encoder;
    /**
     * @var CreateUser
     */
    private $useCase;

    public function testInstantiation()
    {
        $this->assertInstanceOf(CreateUser::class, $this->useCase);

    }

    public function test_CreateUserRequest_returnsUserResponse()
    {
        $username      = self::TIMMY;
        $plainPassword = self::PLAIN_PASS;
        $eMail         = self::TIMMY_MAIL;

        $this->expectGatewaySaveCall($username);
        $this->expectPasswordEncoderCall($plainPassword);

        $request = $this->makeRequestDTO($username, $plainPassword, $eMail);

        $result = $this->useCase->execute($request);

        $this->assertInstanceOf(UserResponseDTO::class, $result);
        $this->assertEquals($username, $result->getUserName());
        $this->assertEquals($eMail, $result->getEMail());
        $this->assertNotEquals($plainPassword, $result->getPassword());

        $this->assertEquals(999, $result->getId());
    }

    public function test_CreateUserRequest_deniesImmediateAccess_by_default()
    {
        $username  = self::TIMMY;
        $plainPass = self::PLAIN_PASS;
        $eMail     = self::TIMMY_MAIL;

        $this->expectGatewaySaveCall($username);
        $this->expectPasswordEncoderCall($plainPass);

        $request = $this->makeRequestDTO($username, $plainPass, $eMail);

        $result = $this->useCase->execute($request);

        $this->assertFalse($result->isEnabled());
    }

    public function test_CreateUserRequest_grantsImmediateAccess()
    {
        $username  = self::TIMMY;
        $plainPass = self::PLAIN_PASS;
        $eMail     = self::TIMMY_MAIL;

        $this->expectGatewaySaveCall($username);
        $this->expectPasswordEncoderCall($plainPass);

        $request = $this->makeRequestDTO($username, $plainPass, $eMail);

        $request->grantImmediateAccess();

        $result = $this->useCase->execute($request);

        $this->assertTrue($result->isEnabled());

    }

    public function test_CreateUserRequest_persistenceFailure_throwsPersistenceFailed()
    {
        $this->encoder->expects('encode')->andReturn('');
        $this->gateway->expects('save')->andThrows(new PersistenceFailed());

        $this->expectException(PersistenceFailed::class);
        $this->useCase->execute(CreateUserRequestDTO::create());


    }

    protected function setUp()
    {
        $this->encoder = mock(IPasswordEncoder::class);
        $this->useCase = new CreateUser($this->encoder);

        $this->gateway = mock(IUserGateway::class);
        $this->gateway->allows('produce')->andReturn(new UserImpl());

        $this->useCase->setUserGateway($this->gateway);
        $this->useCase->setResponseTransformer(new UserResponseTransformer());

    }

    /**
     * @param $username
     */
    private function expectGatewaySaveCall($username)
    {
        $this
            ->gateway
            ->expects('save')
            ->with(
                argumentThat(
                    function (User $user) use ($username) {
                        return $user->getUserName() === $username;
                    }
                )
            )
            ->andReturnUsing(
                function (User $user) {
                    return identify($user, 999);
                }
            )
        ;
    }

    /**
     * @param $plainPassword
     *
     * @return bool|string
     */
    private function expectPasswordEncoderCall($plainPassword)
    {
        $passwordHash = password_hash($plainPassword, PASSWORD_BCRYPT);

        $this
            ->encoder
            ->expects('encode')
            ->with($plainPassword, null)
            ->andReturnUsing(
                function ($plainPassword, $salt) use ($passwordHash) {
                    return $passwordHash;
                }
            )
        ;

        return $passwordHash;
    }

    /**
     * @param $username
     * @param $plainPass
     * @param $eMail
     *
     * @return ICreateUserRequest
     */
    private function makeRequestDTO($username, $plainPass, $eMail)
    {
        $request = CreateUserRequestDTO::create();
        $request->withUserName($username)
                ->withPlainPassword($plainPass)
                ->withEMail($eMail)
        ;

        return $request;
    }


}
