<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Integration\UseCases\User;

use Tidy\Components\Util\IStringUtilFactory;
use Tidy\Domain\BusinessRules\UserRules;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Integration\Components\Components;
use Tidy\Integration\Domain\BusinessRules;
use Tidy\Integration\Domain\Gateways;
use Tidy\UseCases\User\Activate;
use Tidy\UseCases\User\Create;
use Tidy\UseCases\User\GetCollection;
use Tidy\UseCases\User\LookUp;
use Tidy\UseCases\User\Recover;
use Tidy\UseCases\User\ResetPassword;

/**
 * Class UseCaseFactory
 */
class UseCaseFactory implements IUseCaseFactory
{

    /**
     * @var Gateways
     */
    private $gateways;

    /**
     * @var BusinessRules
     */
    private $rules;

    /**
     * @var Components
     */
    private $components;

    /**
     * UseCaseFactory constructor.
     *
     * @param Gateways      $gateways
     * @param BusinessRules $rules
     * @param Components    $components
     */
    public function __construct(Gateways $gateways, BusinessRules $rules, Components $components)
    {
        $this->gateways   = $gateways;
        $this->rules      = $rules;
        $this->components = $components;
    }


    /**
     * @return Create
     */
    public function makeCreate()
    {
        return new Create($this->users(), $this->rules(), $this->stringUtils());

    }

    /**
     * @return Activate
     */
    public function makeActivate()
    {
        return new Activate($this->users(), $this->rules());
    }

    /**
     * @return Recover
     */
    public function makeRecover()
    {
        return new Recover($this->users(), $this->rules());
    }

    /**
     * @return ResetPassword
     */
    public function makeResetPassword()
    {
        return new ResetPassword($this->stringUtils(), $this->rules(), $this->users());
    }

    /**
     * @return LookUp
     */
    public function makeLookUp()
    {
        return new LookUp($this->users());
    }

    /**
     * @return GetCollection
     */
    public function makeGetCollection()
    {
        return new GetCollection($this->users());
    }


    /**
     * @return IUserGateway
     */
    private function users()
    {
        return $this->gateways->users();
    }

    /**
     * @return UserRules
     */
    private function rules()
    {
        return $this->rules->userRules();
    }

    /**
     * @return IStringUtilFactory
     */
    private function stringUtils()
    {
        return $this->components->stringUtilFactory();
    }


}