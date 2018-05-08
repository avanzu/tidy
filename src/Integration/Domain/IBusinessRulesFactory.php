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

interface  IBusinessRulesFactory
{
    /**
     * @return UserRules
     */
    public function makeUserRules();

    /**
     * @return ProjectRules
     */
    public function makeProjectRules();

    /**
     * @return TranslationRules
     */
    public function makeTranslationRules();
}