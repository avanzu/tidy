<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Integration\UseCases\Project;

use Tidy\Integration\Components\Components;
use Tidy\Integration\Domain\AccessControl;
use Tidy\Integration\Domain\BusinessRules;
use Tidy\Integration\Domain\Gateways;
use Tidy\UseCases\Project\Create;

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
     * @var AccessControl
     */
    private $accessControl;

    public function __construct(Gateways $gateways, BusinessRules $rules, AccessControl $accessControl)
    {

        $this->gateways   = $gateways;
        $this->rules      = $rules;
        $this->accessControl = $accessControl;
    }

    public function makeCreate()
    {
        return new Create($this->projects(), $this->rules(), $this->broker());
    }

    private function projects()
    {
        return $this->gateways->projects();
    }

    private function rules()
    {
        return $this->rules->projectRules();
    }

    /**
     * @return mixed
     */
    private function broker()
    {
        return $this->accessControl->broker();
    }

}