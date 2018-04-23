<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */
namespace Tidy\Domain\Responders\Audit;

use Tidy\Components\Audit\ChangeSet;

interface IChangeResponseTransformer
{
    /**
     * @param ChangeSet $changeSet
     *
     * @return IChangeResponse
     */
    public function transform(ChangeSet $changeSet);
}