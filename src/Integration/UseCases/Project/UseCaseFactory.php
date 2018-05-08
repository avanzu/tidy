<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Integration\UseCases\Project;

use Tidy\Integration\Components\Components;
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

    public function __construct(Gateways $gateways, BusinessRules $rules, Components $components)
    {

        $this->gateways   = $gateways;
        $this->rules      = $rules;
        $this->components = $components;
    }

    public function makeCreate()
    {
        return new Create($this->projects(), $this->rules(), $this->components->accessControlBroker($this->gateways->users()));
    }

    private function projects()
    {
        return $this->gateways->projects();
    }

    private function rules()
    {
        return $this->rules->projectRules();
    }

}