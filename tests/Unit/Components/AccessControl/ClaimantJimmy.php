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
    const ID   = 321;
    const NAME = 'Jimmy';

    protected $id   = self::ID;
    protected $name = self::NAME;

    /**
     * @return int
     */
    public function identify()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }


}