<?php
/**
 * CreateTest.phptidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Components\Normalisation\ITextNormaliser;
use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Components\Util\StringUtilFactory;
use Tidy\Components\Validation\IPasswordStrengthValidator;
use Tidy\Components\Validation\Validators\EMailValidator;
use Tidy\Components\Validation\Validators\PasswordStrengthValidator;
use Tidy\Domain\Entities\User;
use Tidy\Domain\Entities\UserProfile;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Requestors\User\ICreateRequest;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TimmyUser;
use Tidy\Tests\Unit\Fixtures\Entities\UserImpl;
use Tidy\UseCases\User\Create;
use Tidy\UseCases\User\DTO\CreateRequestBuilder;
use Tidy\UseCases\User\DTO\ResponseDTO;
use Tidy\UseCases\User\DTO\ResponseTransformer;

class CreateTest extends MockeryTestCase
{
    const TIMMY           = self::TIMMY_FIRSTNAME;
    const PLAIN_PASS      = '$aAbB12!#';
    const TIMMY_MAIL      = 'timmy@example.com';
    const TIMMY_FIRSTNAME = 'Timmy';
    const TIMMY_LASTNAME  = 'Tungsten';

    /**
     * @var \Tidy\Domain\Gateways\IUserGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var IPasswordEncoder|MockInterface
     */
    protected $encoder;

    /**
     * @var ITextNormaliser|MockInterface
     */
    protected $normaliser;

    /**
     * @var StringUtilFactory|MockInterface
     */
    protected $factory;

    /**
     * @var Create
     */
    private $useCase;

    public function testInstantiation()
    {
        $useCase = new Create(mock(IUserGateway::class), mock(IStringUtilFactory::class));
        assertThat($useCase, is(notNullValue()));

        $this->assertInstanceOf(Create::class, $this->useCase);
    }

    public function test_CreateUserRequest_returnsUserResponse()
    {
        $username      = self::TIMMY;
        $plainPassword = self::PLAIN_PASS;
        $eMail         = self::TIMMY_MAIL;
        $firstName     = self::TIMMY_FIRSTNAME;
        $lastName      = self::TIMMY_LASTNAME;

        $this->expectRequestVerification($username, $plainPassword);
        $this->expectGatewaySaveCall($username);

        $request = $this->makeRequestDTO($username, $plainPassword, $eMail, $firstName, $lastName);

        $result = $this->useCase->execute($request);

        $this->assertInstanceOf(ResponseDTO::class, $result);

        $this->assertEquals($username, $result->getUserName(), 'username should be assigned');
        $this->assertEquals($eMail, $result->getEMail(), 'email should be assigned');
        $this->assertNotEmpty($result->getPassword(), 'password should be assigned');
        $this->assertNotEquals($plainPassword, $result->getPassword(), 'plain password should be encoded');
        $this->assertEquals($firstName, $result->getFirstName(), 'FirstName should be assigned.');
        $this->assertEquals($lastName, $result->getLastName(), 'LastName should be assigned.');

        $this->assertIssUuid($result->getId());
    }

    public function test_CreateUserRequest_deniesImmediateAccess_by_default()
    {
        $username      = self::TIMMY;
        $plainPassword = self::PLAIN_PASS;
        $eMail         = self::TIMMY_MAIL;
        $firstName     = self::TIMMY_FIRSTNAME;
        $lastName      = self::TIMMY_LASTNAME;

        $this->expectRequestVerification($username, $plainPassword);
        $this->expectGatewaySaveCall($username);

        $request = $this->makeRequestDTO($username, $plainPassword, $eMail, $firstName, $lastName);
        /** @var ResponseDTO $result */
        $result = $this->useCase->execute($request);

        $this->assertFalse($result->isEnabled(), 'user should not be enabled by default');

        // user should have a token
        $this->assertNotEmpty($result->getToken(), 'user should have a token ');
    }

    public function test_CreateUserRequest_grantsImmediateAccess()
    {
        $username      = self::TIMMY;
        $plainPassword = self::PLAIN_PASS;
        $eMail         = self::TIMMY_MAIL;
        $firstName     = self::TIMMY_FIRSTNAME;
        $lastName      = self::TIMMY_LASTNAME;

        $this->expectRequestVerification($username, $plainPassword);
        $this->expectGatewaySaveCall($username);

        $request = $this->makeRequestDTOWithImmediateAccess($username, $plainPassword, $eMail, $firstName, $lastName);

        $result = $this->useCase->execute($request);

        $this->assertTrue($result->isEnabled(), 'user should be enabled');
        $this->assertEmpty($result->getToken(), 'user should not have a token');

    }

    public function test_create_verifies()
    {
        $this->expectEMailValidationUsingFactory();
        $this->expectPasswordStrengthCheck();

        $dto = $this->makeRequestDTO('a', '', '123abc', '', '');
        try {
            $this->useCase->execute($dto);
            $this->fail('Failed to fail.');
        } catch (PreconditionFailed $exception) {
            $this->assertStringMatchesFormat(
                'Username "%s" is not allowed. Must be at least 3 characters long.',
                $exception->atIndex('username')
            );
            $this->assertStringMatchesFormat(
                'EMail address "%s" is not valid.',
                $exception->atIndex('email')
            );
            $this->assertStringStartsWith(
                "Password is too weak. Please make sure to meet the following requirements:\n",
                $exception->atIndex('plainPassword')
            );
        }

    }

    public function test_create_verifies_unique_username()
    {
        $this->expectEMailValidationUsingFactory();
        $this->expectPasswordStrengthCheck();
        $this->expectUserNameLookUp(new TimmyUser());

        $dto = $this->makeRequestDTO(TimmyUser::USERNAME, self::PLAIN_PASS, self::TIMMY_MAIL, '', '');
        try {
            $this->useCase->execute($dto);
            $this->fail('Failed to fail.');
        } catch (PreconditionFailed $exception) {
            $this->assertStringMatchesFormat('Username "%s" is already taken.', $exception->atIndex('username'));
        }

    }


    protected function setUp()
    {
        $this->encoder    = mock(IPasswordEncoder::class);
        $this->gateway    = mock(IUserGateway::class);
        $this->normaliser = mock(ITextNormaliser::class);
        $this->factory    = mock(IStringUtilFactory::class);
        $this->useCase    = new Create($this->gateway, $this->factory);

        $this->gateway->allows('makeUser')->andReturn(new UserImpl());

        $this->useCase->setUserGateway($this->gateway);
        $this->useCase->setTransformer(new ResponseTransformer());

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

    protected function expectUserNameLookUp($returnValue)
    {
        $this->gateway->expects('findByUserName')->andReturn($returnValue);
    }

    /**
     * @param $username
     * @param $plainPassword
     */
    protected function expectRequestVerification($username, $plainPassword): void
    {
        $this->expectPasswordEncoderCallUsingFactory($plainPassword);
        $this->expectNormaliserCallUsingFactory($username);
        $this->expectEMailValidationUsingFactory();
        $this->expectPasswordStrengthCheck();
        $this->expectUserNameLookUp(null);
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
                        if (!($user->getProfile() instanceof UserProfile)) {
                            return false;
                        }

                        return $user->getUserName() === $username;
                    }
                )
            )
        ;
    }

    /**
     * @param $plainPassword
     *
     * @return bool|string
     */
    private function expectPasswordEncoderCallUsingFactory($plainPassword)
    {
        $passwordHash = password_hash($plainPassword, PASSWORD_BCRYPT);
        $this->factory->expects('createEncoder')->andReturn($this->encoder);
        $this
            ->encoder
            ->expects('encode')
            ->with($plainPassword, null)
            ->andReturnUsing(
                function () use ($passwordHash) {
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
     * @return ICreateRequest
     */
    private function makeRequestDTO($username, $plainPass, $eMail, $firstName, $lastName)
    {

        return (new CreateRequestBuilder())
            ->withUserName($username)
            ->withPlainPassword($plainPass)
            ->withEMail($eMail)
            ->witFirstName($firstName)
            ->withLastName($lastName)
            ->build()
            ;

    }

    /**
     * @param $username
     * @param $plainPass
     * @param $eMail
     *
     * @param $firstName
     * @param $lastName
     *
     * @return ICreateRequest
     */
    private function makeRequestDTOWithImmediateAccess($username, $plainPass, $eMail, $firstName, $lastName)
    {

        return (new CreateRequestBuilder())
            ->withUserName($username)
            ->withPlainPassword($plainPass)
            ->withEMail($eMail)
            ->witFirstName($firstName)
            ->withLastName($lastName)
            ->grantImmediateAccess()
            ->build()
            ;

    }


    private function expectNormaliserCallUsingFactory($username)
    {
        $this->factory->expects('createNormaliser')->andReturn($this->normaliser);
        $this->normaliser->expects('transform')->with($username)->andReturn($username);
    }

    private function expectEMailValidationUsingFactory()
    {
        $this->factory->expects('createEMailValidator')->andReturn(new EmailValidator());
    }


}
