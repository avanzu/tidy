<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\Tests\Unit\Components\Events;

use Tidy\Components\Events\Event;

class TestCaseExecuted extends Event
{
    const NAME = 'testcase_executed';

    public $info;

}