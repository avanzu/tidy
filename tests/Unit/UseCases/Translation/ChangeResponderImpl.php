<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation;

use Tidy\Components\Audit\ChangeSet;
use Tidy\Domain\Responders\Audit\IChangeResponse;
use Tidy\Domain\Responders\Translation\ChangeResponder;

class ChangeResponderImpl extends ChangeResponder
{

    /**
     * @param ChangeSet $changeSet
     *
     * @return IChangeResponse
     */
    public function run(ChangeSet $changeSet)
    {
        return $this->transformer()->transform($changeSet);
    }

}