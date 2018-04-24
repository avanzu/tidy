<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\Components\Audit;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Tests\MockeryTestCase;

class ChangeSetTest extends MockeryTestCase
{

    public function test_instantiation()
    {
        $changeSet = ChangeSet::make();
        assertThat(count($changeSet), is(0));

        $changeSet = ChangeSet::make(
            Change::add('a', 'b'),
            change::remove('b'),
            Change::move('c', 'b')
        );

        assertThat(count($changeSet), is(3));

    }
}