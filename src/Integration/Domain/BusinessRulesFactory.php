<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Integration\Domain;

use Tidy\Domain\BusinessRules\ProjectRules;
use Tidy\Domain\BusinessRules\TranslationRules;
use Tidy\Domain\BusinessRules\UserRules;
use Tidy\Integration\Components\Components;

class BusinessRulesFactory implements IBusinessRulesFactory
{

    /**
     * @var Components
     */
    protected $components;

    /**
     * @var Gateways
     */
    protected $gateways;

    /**
     * BusinessRulesFactory constructor.
     *
     * @param Components $components
     * @param Gateways   $gateways
     */
    public function __construct(Components $components, Gateways $gateways)
    {
        $this->components = $components;
        $this->gateways   = $gateways;
    }


    /**
     * @return UserRules
     */
    public function makeUserRules()
    {
        return new UserRules($this->components->stringUtilFactory(), $this->gateways->users());
    }

    /**
     * @return ProjectRules
     */
    public function makeProjectRules()
    {
        return new ProjectRules($this->gateways->projects());
    }

    /**
     * @return TranslationRules
     */
    public function makeTranslationRules()
    {
        return new TranslationRules($this->gateways->translations());
    }
}