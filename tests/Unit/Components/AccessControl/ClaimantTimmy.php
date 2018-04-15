<?php
/**
 * ClaimantTimmy.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\Components\AccessControl;


use Tidy\Components\AccessControl\IClaimant;

class ClaimantTimmy implements IClaimant
{
    const ID = 223344;

    protected $id = self::ID;
    /**
     * @return int
     */
    public function identify()
    {
        return $this->id;
    }
}