<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Integration\UseCases\User;

use Tidy\Integration\Components\Components;
use Tidy\Integration\Domain\BusinessRules;
use Tidy\Integration\Domain\Gateways;
use Tidy\UseCases\User\Activate;
use Tidy\UseCases\User\Create;

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

    public function __construct(Gateways $gateways, BusinessRules $rules, Components $components)
    {

        $this->gateways   = $gateways;
        $this->rules      = $rules;
        $this->components = $components;
    }

    public function makeCreate()
    {
        return new Create(
            $this->gateways->users(),
            $this->rules->userRules(),
            $this->components->stringUtilFactory()
        );

    }

    /**
     * @return Activate
     */
    public function makeActivate() {
        return new Activate(
            $this->gateways->users(),
            $this->rules->userRules()
        );
    }


}