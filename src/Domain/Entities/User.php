<?php
/**
 * User.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Entities;

use Tidy\Components\AccessControl\IClaimant;
use Tidy\Components\Events\IMessenger;
use Tidy\Components\Events\TMessenger;
use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Domain\BusinessRules\UserRules;
use Tidy\Domain\Events\User\Activated;
use Tidy\Domain\Events\User\PasswordReset;
use Tidy\Domain\Events\User\Recovering;
use Tidy\Domain\Events\User\Registered;
use Tidy\Domain\Requestors\User\IActivateRequest;
use Tidy\Domain\Requestors\User\ICreateRequest;
use Tidy\Domain\Requestors\User\IRecoverRequest;
use Tidy\Domain\Requestors\User\IResetPasswordRequest;

/**
 * Class User
 */
abstract class User implements IClaimant, IMessenger
{

    use TMessenger;

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
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
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


    public function getProfile()
    {
        return $this->profile;
    }


    /**
     * Attempts to create a new User entity using the given request.
     *
     * @param ICreateRequest     $request
     * @param UserRules          $rules
     * @param IStringUtilFactory $factory
     *
     */
    public function register(ICreateRequest $request, UserRules $rules, IStringUtilFactory $factory)
    {

        $rules->verifyRegister($request);

        $this->id        = coalesce($this->id, uuid());
        $this->userName  = $request->getUserName();
        $this->eMail     = $request->eMail();
        $this->password  = $this->encodePlainPassword($factory, $request->plainPassword());
        $this->canonical = $factory->createNormaliser()->transform($this->userName);
        $this->profile   = $this->makeProfile(
            $request->firstName(),
            $request->lastName()
        );

        $this->queueEvent(new Registered($this->id));

        $this->grantAccessOrAssignToken($request);

    }

    /**
     * Attempts to activate this user and removes the token on success.
     *
     * @param IActivateRequest $request
     * @param UserRules        $rules
     *
     */
    public function activate(IActivateRequest $request, UserRules $rules)
    {

        $rules->verifyActivate($this, $request);

        $this->enabled = true;
        $this->token   = null;

        $this->queueEvent(new Activated($this->id));
    }

    public function recover(IRecoverRequest $request, UserRules $rules)
    {
        $rules->verifyRecover($request);
        $this->token = uniqid();
        $this->queueEvent(new Recovering($this->id));
    }


    /**
     * @param IResetPasswordRequest $request
     * @param UserRules             $rules
     * @param IStringUtilFactory    $factory
     */
    public function resetPassword(IResetPasswordRequest $request, UserRules $rules, IStringUtilFactory $factory)
    {
        $rules->verifyResetPassword($this, $request);
        $this->password = $this->encodePlainPassword($factory, $request->plainPassword());
        $this->token    = null;

        $this->queueEvent(new PasswordReset($this->id));
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
            $this->queueEvent(new Activated($this->id));

            return $this;
        }

        $this->token   = uniqid();
        $this->enabled = false;

        return $this;
    }


    /**
     * @param IStringUtilFactory $factory
     * @param                    $plainPassword
     *
     * @return string
     */
    private function encodePlainPassword(IStringUtilFactory $factory, $plainPassword)
    {
        $encode = $factory->createEncoder()->encode($plainPassword, null);

        return $encode;
    }


}