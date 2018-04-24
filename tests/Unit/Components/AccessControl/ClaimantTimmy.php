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
    const ID   = 223344;
    const NAME = 'Timmy';

    protected $id   = self::ID;

    protected $name = self::NAME;

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function identify()
    {
        return $this->id;
    }


}