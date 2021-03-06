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
use Tidy\Components\Validation\ErrorList;
use Tidy\Components\Validation\IPasswordStrengthValidator;
use Tidy\Components\Validation\Violation;
use Tidy\Domain\Entities\User;
use Tidy\Domain\Gateways\IUserGateway;
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
     * @var IUserGateway
     */
    protected $gateway;

    /**
     * UserRules constructor.
     *
     * @param IStringUtilFactory $factory
     * @param IUserGateway       $gateway
     */
    public function __construct(IStringUtilFactory $factory, IUserGateway $gateway)
    {
        $this->factory = $factory;
        $this->gateway = $gateway;
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
            $errors['username'] = new Violation(
                'Username "{{ username }}" is not allowed. Must be at least 3 characters long.',
                ['{{ username }}' => $request->getUserName()]
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
    protected function verifyEMailAddress(ICreateRequest $request, $errors)
    {
        if (!$this->factory->createEMailValidator()->validate($request->eMail())) {
            $errors['email'] = new Violation(
                'EMail address "{{ email }}" is not valid.',
                ['{{ email }}' => $request->eMail()]
            );
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
            $errors['plainPassword'] = new Violation(
                "Password is too weak. Please make sure to meet the following requirements:\n%{{ list }}",
                ['{{ list }}' => $validator->violations()->list()]
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
        if ($user = $this->gateway->findByUserName($request->getUserName())) {
            $errors['username'] = new Violation(
                'Username "{{ username }}" is already taken.',
                ['{{ username }}' => $request->getUserName()]
            );
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
            $errors['token'] = new Violation(
                'Token "{{ token }}" does not match expected "{{ expected }}".',
                ['{{ token }}' => $request->token(), '{{ expected }}' => $user->getToken()]
            );
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