<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 07.05.18
 *
 */

namespace Tidy\Domain\BusinessRules;

use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Components\Util\StringUtilFactory;
use Tidy\Components\Validation\ErrorList;
use Tidy\Components\Validation\IPasswordStrengthValidator;
use Tidy\Domain\Collections\Users;
use Tidy\Domain\Entities\User;
use Tidy\Domain\Requestors\User\IActivateRequest;
use Tidy\Domain\Requestors\User\ICreateRequest;
use Tidy\Domain\Requestors\User\IPlainPassword;
use Tidy\Domain\Requestors\User\IRecoverRequest;
use Tidy\Domain\Requestors\User\IResetPasswordRequest;
use Tidy\Domain\Requestors\User\IToken;

/**
 * Class UserRules
 */
class UserRules
{

    /**
     * @var IStringUtilFactory
     */
    protected $factory;

    /**
     * @var Users
     */
    protected $users;

    /**
     * UserRules constructor.
     *
     * @param IStringUtilFactory $factory
     * @param Users              $users
     */
    public function __construct(IStringUtilFactory $factory, Users $users)
    {
        $this->factory = $factory;
        $this->users   = $users;
    }


    /**
     * @param ICreateRequest $request
     */
    public function verifyRegister(ICreateRequest $request)
    {
        $errors = new ErrorList();
        $errors = $this->verifyUserName($request, $errors);
        $errors = $this->verifyEMailAddress($request, $errors);
        $errors = $this->verifyPlainPassword($request, $errors);
        $this->failOnErrors($errors);

        $errors = $this->verifyUniqueUserName($request, $errors);
        $this->failOnErrors($errors);

    }

    /**
     * @param User                  $user
     * @param IResetPasswordRequest $request
     */
    public function verifyResetPassword(User $user, IResetPasswordRequest $request)
    {
        $errors = new ErrorList();
        $errors = $this->verifyToken($user, $request, $errors);
        $errors = $this->verifyPlainPassword($request, $errors);

        $this->failOnErrors($errors);
    }

    /**
     * @param User             $user
     * @param IActivateRequest $request
     */
    public function verifyActivate(User $user, IActivateRequest $request)
    {
        $errors = new ErrorList();
        $errors = $this->verifyToken($user, $request, $errors);
        $this->failOnErrors($errors);
    }

    public function verifyRecover(IRecoverRequest $request) { }


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
     * @param                    $errors
     *
     * @return mixed
     */
    protected function verifyEMailAddress(ICreateRequest $request,  $errors)
    {
        if (!$this->factory->createEMailValidator()->validate($request->eMail())) {
            $errors['email'] = sprintf('EMail address "%s" is not valid.', $request->eMail());
        }

        return $errors;
    }

    /**
     * @param IPlainPassword     $request
     * @param                    $errors
     *
     * @return mixed
     */
    protected function verifyPlainPassword(IPlainPassword $request, $errors)
    {
        $validator = $this->factory->createPasswordStrengthValidator(IPasswordStrengthValidator::STRENGTH_STRONG);
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
     * @param                $errors
     *
     * @return mixed
     */
    protected function verifyUniqueUserName(ICreateRequest $request, $errors)
    {
        if ($user = $this->users->findByUserName($request->getUserName())) {
            $errors['username'] = sprintf('Username "%s" is already taken.', $request->getUserName());
        }

        return $errors;
    }

    /**
     * @param User             $user
     * @param IToken           $request
     * @param                  $errors
     *
     * @return mixed
     */
    protected function verifyToken(User $user, IToken $request, $errors)
    {
        if ($request->token() !== $user->getToken()) {
            $errors['token'] = sprintf('Token "%s" does not match expected "%s".', $request->token(), $user->getToken());
        }

        return $errors;
    }

    /**
     * @param ErrorList $errors
     */
    private function failOnErrors(ErrorList $errors)
    {
        if ($errors->count() > 0) {
            throw new PreconditionFailed($errors->getArrayCopy());
        }
    }

}