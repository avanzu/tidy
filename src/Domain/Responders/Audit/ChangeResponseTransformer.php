<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Domain\Responders\Audit;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;

class ChangeResponseTransformer implements IChangeResponseTransformer
{

    public function transform(ChangeSet $changeSet)
    {

        $response = new ChangeResponse();
        /** @var Change $change */
        foreach ($changeSet as $change) {
            $response->changes[] = array_filter((array)$change);
        }

        return $response;
    }
}