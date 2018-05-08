<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Integration\UseCases\User;

use Tidy\UseCases\User\Activate;
use Tidy\UseCases\User\Create;
use Tidy\UseCases\User\GetCollection;
use Tidy\UseCases\User\LookUp;
use Tidy\UseCases\User\Recover;
use Tidy\UseCases\User\ResetPassword;

interface IUseCaseFactory
{

    /**
     * @return Create
     */
    public function makeCreate();

    /**
     * @return Activate
     */
    public function makeActivate();

    /**
     * @return Recover
     */
    public function makeRecover();

    /**
     * @return ResetPassword
     */
    public function makeResetPassword();

    /**
     * @return LookUp
     */
    public function makeLookUp();

    /**
     * @return GetCollection
     */
    public function makeGetCollection();
}