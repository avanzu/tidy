<?php
/**
 * IClaimable.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Components\AccessControl;

interface IClaimable
{
    public function grantOwnershipTo(IClaimant $user);


}