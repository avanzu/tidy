<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Events;

use Tidy\Domain\Events\Event;

class TestCaseExecuted extends Event
{
    public $info;

}