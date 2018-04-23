<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;

class ChangeResponseTransformer
{

    public function transform(ChangeSet $changeSet) {

        $response = new ChangeResponseDTO();
        /** @var Change $change */
        foreach ($changeSet as $change) {
            $response->changes[] = array_filter((array)$change);
        }

        return $response;
    }
}