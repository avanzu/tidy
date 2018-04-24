<?php
/**
 * ClaimableImpl.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\Components\AccessControl;

use Tidy\Components\AccessControl\IClaimable;
use Tidy\Components\AccessControl\IClaimant;

class ClaimableImpl implements IClaimable
{
    const ID = 112233;

    protected $id = self::ID;

    /**
     * @var IClaimant
     */
    protected $owner;

    /**
     * ClaimableImpl constructor.
     *
     * @param $owner
     */
    public function __construct(IClaimant $owner) { $this->owner = $owner; }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    public function grantOwnershipTo(IClaimant $user)
    {
        $previous    = $this->owner;
        $this->owner = $user;

        return $previous;
    }
}