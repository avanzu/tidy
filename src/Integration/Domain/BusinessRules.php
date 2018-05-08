<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Integration\Domain;

use Tidy\Components\Collection\ObjectMap;
use Tidy\Components\DependencyInjection\Container;
use Tidy\Domain\BusinessRules\ProjectRules;
use Tidy\Domain\BusinessRules\TranslationRules;
use Tidy\Domain\BusinessRules\UserRules;

/**
 * Class BusinessRules
 */
class BusinessRules extends Container
{

    /**
     * @var IBusinessRulesFactory
     */
    protected $factory;


    /**
     * BusinessRules constructor.
     *
     * @param IBusinessRulesFactory $factory
     */
    const TRANSLATION_RULES = 'translation_rules';

    const PROJECT_RULES = 'project_rules';

    const USER_RULES = 'user_rules';

    public function __construct(IBusinessRulesFactory $factory)
    {
        $this->factory   = $factory;
    }

    /**
     * @return TranslationRules
     */
    public function translationRules()
    {
        if( ! $this->contains(self::TRANSLATION_RULES) ){
            $this->attach(self::TRANSLATION_RULES, $this->factory->makeTranslationRules());
        }
        return $this->reveal(self::TRANSLATION_RULES);
    }

    /**
     * @return ProjectRules
     */
    public function projectRules()
    {

        if( ! $this->contains(self::PROJECT_RULES)) {
            $this->attach(self::PROJECT_RULES, $this->factory->makeProjectRules());
        }
        return $this->reveal(self::PROJECT_RULES);
    }

    /**
     * @return UserRules
     */
    public function userRules()
    {
        if( ! $this->contains(self::USER_RULES)) {
            $this->attach(self::USER_RULES, $this->factory->makeUserRules());
        }
        return $this->reveal(self::USER_RULES);

    }

}