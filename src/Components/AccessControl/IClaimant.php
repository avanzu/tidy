<?php
/**
 * IClaimant.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Components\AccessControl;

interface IClaimant
{
    /**
     * @return int
     */
    public function identify();

    public function getName();
}