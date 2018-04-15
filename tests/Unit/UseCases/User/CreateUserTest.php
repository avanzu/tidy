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
use Tidy\Entities\UserProfile;
use Tidy\Exceptions\PersistenceFailed;
use Tidy\Gateways\IUserGateway;
use Tidy\Requestors\User\ICreateUserRequest;
use Tidy\Responders\User\IUserResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Entities\UserImpl;
use Tidy\Tests\Unit\Entities\UserProfileImpl;
use Tidy\UseCases\User\CreateUser;
use Tidy\UseCases\User\DTO\CreateUserRequestDTO;
use Tidy\UseCases\User\DTO\UserResponseDTO;
use Tidy\UseCases\User\DTO\UserResponseTransformer;

class CreateUserTest extends MockeryTestCase
{
    const TIMMY      = self::TIMMY_FIRSTNAME;
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

    const TIMMY_FIRSTNAME = 'Timmy';

    const TIMMY_LASTNAME = 'Tungsten';

    public function testInstantiation()
    {
        $this->assertInstanceOf(CreateUser::class, $this->useCase);

    }

    public function test_CreateUserRequest_returnsUserResponse()
    {
        $username      = self::TIMMY;
        $plainPassword = self::PLAIN_PASS;
        $eMail         = self::TIMMY_MAIL;
        $firstName     = self::TIMMY_FIRSTNAME;
        $lastName      = self::TIMMY_LASTNAME;

        $this->expectGatewaySaveCall($username);
        $this->expectPasswordEncoderCall($plainPassword);


        $request   = $this->makeRequestDTO($username, $plainPassword, $eMail, $firstName, $lastName);

        $result = $this->useCase->execute($request);

        $this->assertInstanceOf(UserResponseDTO::class, $result);

        $this->assertEquals($username, $result->getUserName(), 'username should be assigned');
        $this->assertEquals($eMail, $result->getEMail(), 'email should be assigned');
        $this->assertNotEmpty($result->getPassword(), 'password should be assigned');
        $this->assertNotEquals($plainPassword, $result->getPassword(),'plain password should be encoded');
        $this->assertEquals($firstName, $result->getFirstName(), 'FirstName should be assigned.');
        $this->assertEquals($lastName, $result->getLastName(), 'LastName should be assigned.');


        $this->assertEquals(999, $result->getId());
    }

    public function test_CreateUserRequest_deniesImmediateAccess_by_default()
    {
        $username  = self::TIMMY;
        $plainPass = self::PLAIN_PASS;
        $eMail     = self::TIMMY_MAIL;
        $firstName = self::TIMMY_FIRSTNAME;
        $lastName  = self::TIMMY_LASTNAME;

        $this->expectGatewaySaveCall($username);
        $this->expectPasswordEncoderCall($plainPass);

        $request = $this->makeRequestDTO($username, $plainPass, $eMail, $firstName, $lastName);
        /** @var UserResponseDTO $result */
        $result = $this->useCase->execute($request);

        $this->assertFalse($result->isEnabled(), 'user should not be enabled by default');

        // user should have a token
        $this->assertNotEmpty($result->getToken(), 'user should have a token ');
    }

    public function test_CreateUserRequest_grantsImmediateAccess()
    {
        $username  = self::TIMMY;
        $plainPass = self::PLAIN_PASS;
        $eMail     = self::TIMMY_MAIL;
        $firstName = self::TIMMY_FIRSTNAME;
        $lastName  = self::TIMMY_LASTNAME;

        $this->expectGatewaySaveCall($username);
        $this->expectPasswordEncoderCall($plainPass);

        $request = $this->makeRequestDTO($username, $plainPass, $eMail, $firstName, $lastName);

        $request->grantImmediateAccess();

        $result = $this->useCase->execute($request);

        $this->assertTrue($result->isEnabled(), 'user should be enabled');
        $this->assertEmpty($result->getToken(), 'user should not have a token');

    }

    public function test_CreateUserRequest_persistenceFailure_throwsPersistenceFailed()
    {
        $this->encoder->expects('encode')->andReturn('');
        $this->gateway->expects('save')->andThrows(new PersistenceFailed());

        $this->expectException(PersistenceFailed::class);
        $this->useCase->execute(CreateUserRequestDTO::make());
    }

    protected function setUp()
    {
        $this->encoder = mock(IPasswordEncoder::class);
        $this->gateway = mock(IUserGateway::class);
        $this->useCase = new CreateUser($this->gateway, mock(IUserResponseTransformer::class), $this->encoder);

        $this->gateway->allows('makeUser')->andReturn(new UserImpl());
        $this->gateway->allows('makeProfile')->andReturn(new UserProfileImpl());

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
                        if(!($user->getProfile() instanceof UserProfile)) return false;
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
     * @param $firstName
     * @param $lastName
     *
     * @return ICreateUserRequest
     */
    private function makeRequestDTO($username, $plainPass, $eMail, $firstName, $lastName)
    {
        $request = CreateUserRequestDTO::make();
        $request->withUserName($username)
                ->withPlainPassword($plainPass)
                ->withEMail($eMail)
                ->witFirstName($firstName)
                ->withLastName($lastName)
        ;

        return $request;
    }


}
