<?php
/**
 * IClaimantProvider.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Components\AccessControl;

interface IClaimantProvider
{
    /**
     * @param $id
     *
     * @return IClaimant
     */
    public function lookUp($id);
}