<?php
/**
 * ClaimantJimmy.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\Components\AccessControl;


use Tidy\Components\AccessControl\IClaimant;

class ClaimantJimmy implements IClaimant
{
    const ID = 321;

    protected $id = self::ID;

    /**
     * @return int
     */
    public function identify()
    {
        return $this->id;
    }
}