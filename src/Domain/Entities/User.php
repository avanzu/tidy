<?php
/**
 * User.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Entities;

use Tidy\Components\AccessControl\IClaimant;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Components\Normalisation\ITextNormaliser;
use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Components\Util\StringConverter;
use Tidy\Components\Validation\ErrorList;
use Tidy\Components\Validation\IPasswordStrengthValidator;
use Tidy\Domain\Collections\Users;
use Tidy\Domain\Requestors\User\ICreateRequest;

/**
 * Class User
 */
abstract class User implements IClaimant
{
    const PREFIX = 'users';

    /**
     * @var
     */
    protected $userName;

    /**
     * @var
     */
    protected $id;

    /**
     * @var
     */
    protected $eMail;

    /**
     * @var
     */
    protected $password;

    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * @var
     */
    protected $token;

    /**
     * @var UserProfile
     */
    protected $profile;

    /**
     * @var string
     */
    protected $path;

    protected $canonical;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->getUserName();
    }

    public function identify()
    {
        return $this->getId();
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }



    public function canonical()
    {
        return $this->canonical;
    }


    /**
     * @return mixed
     */
    public function getEMail()
    {
        return $this->eMail;
    }



    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @param $token
     *
     * @return $this
     */
    public function assignToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return $this
     */
    public function clearToken()
    {
        $this->token = null;

        return $this;
    }

    public function getProfile()
    {
        return $this->profile;
    }


    public function register(
        ICreateRequest $request,
        IStringUtilFactory $factory,
        Users $users
    ) {

        $this->verifyRegister($request, $factory, $users);

        $this->userName  = $request->getUserName();
        $this->eMail     = $request->eMail();
        $this->password  = $factory->createEncoder()->encode($request->plainPassword(), null);
        $this->canonical = $factory->createNormaliser()->transform($this->userName);
        $this->profile   = $this->makeProfile(
            $request->firstName(),
            $request->lastName()
        );

        $this->grantAccessOrAssignToken($request);

    }

    abstract protected function makeProfile($firstName, $lastName);

    /**
     * @param ICreateRequest $request
     *
     * @return User
     */
    protected function grantAccessOrAssignToken(ICreateRequest $request)
    {
        if ($request->isAccessGranted()) {
            $this->enabled = true;
            return $this;
        }

        $this->token   = uniqid();
        $this->enabled = false;
        return $this;
    }

    /**
     * @param ICreateRequest $request
     * @param                $errors
     *
     * @return mixed
     */
    protected function verifyUserName(ICreateRequest $request, $errors)
    {
        if (strlen($request->getUserName()) < 3) {
            $errors['username'] = sprintf(
                'Username "%s" is not allowed. Must be at least 3 characters long.',
                $request->getUserName()
            );
        }

        return $errors;
    }

    /**
     * @param ICreateRequest     $request
     * @param IStringUtilFactory $factory
     * @param                    $errors
     *
     * @return mixed
     */
    protected function verifyEMailAddress(ICreateRequest $request, IStringUtilFactory $factory, $errors)
    {
        if (!$factory->createEMailValidator()->validate($request->eMail())) {
            $errors['email'] = sprintf('EMail address "%s" is not valid.', $request->eMail());
        }

        return $errors;
    }

    /**
     * @param ICreateRequest     $request
     * @param IStringUtilFactory $factory
     * @param Users              $users
     */
    protected function verifyRegister(ICreateRequest $request, IStringUtilFactory $factory, Users $users)
    {
        $errors = new ErrorList();
        $errors = $this->verifyUserName($request, $errors);
        $errors = $this->verifyEMailAddress($request, $factory, $errors);
        $errors = $this->verifyPlainPassword($request, $factory, $errors);
        $this->failOnErrors($errors);

        $errors = $this->verifyUniqueUserName($request, $users, $errors);
        $this->failOnErrors($errors);

    }

    /**
     * @param ICreateRequest $request
     * @param IStringUtilFactory $factory
     * @param                    $errors
     *
     * @return mixed
     */
    protected function verifyPlainPassword(ICreateRequest $request, IStringUtilFactory $factory, $errors)
    {
        $validator = $factory->createPasswordStrengthValidator(IPasswordStrengthValidator::STRENGTH_STRONG);
        if (false === $validator->validate($request->plainPassword())) {
            $errors['plainPassword'] = sprintf(
                "Password is too weak. Please make sure to meet the following requirements:\n%s",
                $validator->violations()->list()
            );
        }

        return $errors;
    }

    /**
     * @param ICreateRequest $request
     * @param Users          $users
     * @param                $errors
     *
     * @return mixed
     */
    protected function verifyUniqueUserName(ICreateRequest $request, Users $users, $errors)
    {
        if ($user = $users->findByUserName($request->getUserName())) {
            $errors['username'] = sprintf('Username "%s" is already taken.', $request->getUserName());
        }

        return $errors;
    }

    private function failOnErrors(ErrorList $errors) {
        if( $errors->count() > 0) {
            throw new PreconditionFailed($errors->getArrayCopy());
        }
    }
}