<?php
/**
 * User.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Entities;

use Tidy\Components\AccessControl\IClaimant;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Components\Validation\ErrorList;
use Tidy\Components\Validation\IPasswordStrengthValidator;
use Tidy\Domain\Collections\Users;
use Tidy\Domain\Requestors\User\IActivateRequest;
use Tidy\Domain\Requestors\User\ICreateRequest;
use Tidy\Domain\Requestors\User\IPlainPassword;
use Tidy\Domain\Requestors\User\IRecoverRequest;
use Tidy\Domain\Requestors\User\IResetPasswordRequest;
use Tidy\Domain\Requestors\User\IToken;

/**
 * Class User
 */
abstract class User implements IClaimant {

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
    protected $enabled = FALSE;

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
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->getUserName();
    }

    public function identify() {
        return $this->getId();
    }

    /**
     * @return mixed
     */
    public function getUserName() {
        return $this->userName;
    }


    public function canonical() {
        return $this->canonical;
    }


    /**
     * @return mixed
     */
    public function getEMail() {
        return $this->eMail;
    }


    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }



    /**
     * @return bool
     */
    public function isEnabled() {
        return $this->enabled;
    }

    /**
     * @param $token
     *
     * @return $this
     */
    public function assignToken($token) {
        $this->token = $token;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getToken() {
        return $this->token;
    }


    public function getProfile() {
        return $this->profile;
    }


    /**
     * Attempts to create a new User entity using the given request.
     *
     * @param ICreateRequest     $request
     * @param IStringUtilFactory $factory
     * @param Users              $users
     *
     * @see User::verifyRegister()
     */
    public function register(ICreateRequest $request, IStringUtilFactory $factory, Users $users) {

        $this->verifyRegister($request, $factory, $users);

        $this->userName  = $request->getUserName();
        $this->eMail     = $request->eMail();
        $this->password  = $this->encodePlainPassword($factory, $request->plainPassword());
        $this->canonical = $factory->createNormaliser()->transform($this->userName);
        $this->profile   = $this->makeProfile(
            $request->firstName(),
            $request->lastName()
        );

        $this->grantAccessOrAssignToken($request);

    }

    /**
     * Attempts to activate this user and removes the token on success.
     *
     * @param IActivateRequest $request
     *
     * @see User::verifyActivate()
     */
    public function activate(IActivateRequest $request) {

        $this->verifyActivate($request);

        $this->enabled = TRUE;
        $this->token   = NULL;
    }

    public function recover(IRecoverRequest $request) {
        $this->verifyRecover($request);
        $this->token = uniqid();
    }

    public function verifyRecover(IRecoverRequest $request) { }

    /**
     * @param IResetPasswordRequest $request
     * @param IStringUtilFactory    $factory
     */
    public function resetPassword(IResetPasswordRequest $request, IStringUtilFactory $factory) {
        $this->verifyResetPassword($request, $factory);
        $this->password = $this->encodePlainPassword($factory, $request->plainPassword());
        $this->token    = NULL;
    }

    public function verifyResetPassword(IResetPasswordRequest $request, IStringUtilFactory $factory) {
        $errors = new ErrorList();
        $errors = $this->verifyToken($request, $errors);
        $errors = $this->verifyPlainPassword($request, $factory, $errors);

        $this->failOnErrors($errors);
    }

    /**
     * @param IActivateRequest $request
     */
    public function verifyActivate(IActivateRequest $request) {
        $errors = new ErrorList();
        $errors = $this->verifyToken($request, $errors);
        $this->failOnErrors($errors);
    }

    /**
     * @param ICreateRequest     $request
     * @param IStringUtilFactory $factory
     * @param Users              $users
     */
    public function verifyRegister(ICreateRequest $request, IStringUtilFactory $factory, Users $users) {
        $errors = new ErrorList();
        $errors = $this->verifyUserName($request, $errors);
        $errors = $this->verifyEMailAddress($request, $factory, $errors);
        $errors = $this->verifyPlainPassword($request, $factory, $errors);
        $this->failOnErrors($errors);

        $errors = $this->verifyUniqueUserName($request, $users, $errors);
        $this->failOnErrors($errors);

    }

    abstract protected function makeProfile($firstName, $lastName);

    /**
     * @param ICreateRequest $request
     *
     * @return User
     */
    protected function grantAccessOrAssignToken(ICreateRequest $request) {
        if ($request->isAccessGranted()) {
            $this->enabled = TRUE;

            return $this;
        }

        $this->token   = uniqid();
        $this->enabled = FALSE;

        return $this;
    }

    /**
     * @param ICreateRequest $request
     * @param                $errors
     *
     * @return mixed
     */
    protected function verifyUserName(ICreateRequest $request, $errors) {
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
    protected function verifyEMailAddress(ICreateRequest $request, IStringUtilFactory $factory, $errors) {
        if (!$factory->createEMailValidator()->validate($request->eMail())) {
            $errors['email'] = sprintf('EMail address "%s" is not valid.', $request->eMail());
        }

        return $errors;
    }

    /**
     * @param IPlainPassword     $request
     * @param IStringUtilFactory $factory
     * @param                    $errors
     *
     * @return mixed
     */
    protected function verifyPlainPassword(IPlainPassword $request, IStringUtilFactory $factory, $errors) {
        $validator = $factory->createPasswordStrengthValidator(IPasswordStrengthValidator::STRENGTH_STRONG);
        if (FALSE === $validator->validate($request->plainPassword())) {
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
    protected function verifyUniqueUserName(ICreateRequest $request, Users $users, $errors) {
        if ($user = $users->findByUserName($request->getUserName())) {
            $errors['username'] = sprintf('Username "%s" is already taken.', $request->getUserName());
        }

        return $errors;
    }

    /**
     * @param IToken           $request
     * @param                  $errors
     *
     * @return mixed
     */
    protected function verifyToken(IToken $request, $errors) {
        if ($request->token() !== $this->token) {
            $errors['token'] = sprintf('Token "%s" does not match expected "%s".', $request->token(), $this->token);
        }

        return $errors;
    }

    private function failOnErrors(ErrorList $errors) {
        if ($errors->count() > 0) {
            throw new PreconditionFailed($errors->getArrayCopy());
        }
    }

    /**
     * @param IStringUtilFactory $factory
     * @param                    $plainPassword
     *
     * @return string
     */
    private function encodePlainPassword(IStringUtilFactory $factory, $plainPassword) {
        $encode = $factory->createEncoder()->encode($plainPassword, NULL);

        return $encode;
    }


}