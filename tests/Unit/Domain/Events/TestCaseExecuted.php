<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Events;

use Tidy\Domain\Events\IEvent;

class TestCaseExecuted implements IEvent
{
    public $info;

}