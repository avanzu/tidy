<?php
/**
 * RenameProjectTest.php
 * Tidy
 * Date: 22.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project;

use Tidy\Tests\MockeryTestCase;
use Tidy\UseCases\Project\RenameProject;

class RenameProjectTest extends MockeryTestCase
{
    public function test_instantiation()
    {
        $useCase = new RenameProject();
        assertThat($useCase, is(notNullValue()));
    }
}