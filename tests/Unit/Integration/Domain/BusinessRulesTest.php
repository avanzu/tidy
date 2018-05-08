<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Integration\Domain;

use Tidy\Domain\BusinessRules\ProjectRules;
use Tidy\Domain\BusinessRules\TranslationRules;
use Tidy\Domain\BusinessRules\UserRules;
use Tidy\Integration\Domain\BusinessRules;
use Tidy\Integration\Domain\IBusinessRulesFactory;
use Tidy\Tests\MockeryTestCase;

class BusinessRulesTest extends MockeryTestCase
{
    public function testInstantiation()
    {
        $rules = new BusinessRules(mock(IBusinessRulesFactory::class));
        $this->assertNotNull($rules);
    }

    public function testProjectRules()
    {
        $factory = mock(IBusinessRulesFactory::class);
        $factory->expects('makeProjectRules')->andReturn(mock(ProjectRules::class));
        $rules        = new BusinessRules($factory);
        $projectRules = $rules->projectRules();
        $this->assertInstanceOf(ProjectRules::class, $projectRules);
        $this->assertSame($projectRules, $rules->projectRules());
    }

    public function testUserRules()
    {
        $factory = mock(IBusinessRulesFactory::class);
        $factory->expects('makeUserRules')->andReturn(mock(UserRules::class));
        $rules     = new BusinessRules($factory);
        $userRules = $rules->userRules();
        $this->assertInstanceOf(UserRules::class, $userRules);
        $this->assertSame($userRules, $rules->userRules());
    }

    public function testTranslationRules()
    {
        $factory = mock(IBusinessRulesFactory::class);
        $factory->expects('makeTranslationRules')->andReturn(mock(TranslationRules::class));
        $rules            = new BusinessRules($factory);
        $translationRules = $rules->translationRules();
        $this->assertInstanceOf(TranslationRules::class, $translationRules);
        $this->assertSame($translationRules, $rules->translationRules());
    }


}