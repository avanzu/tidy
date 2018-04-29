<?php
/**
 * AccessControlBroker.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Components\AccessControl;

use Tidy\Components\Exceptions\NotFound;

class AccessControlBroker
{
    /**
     * @var IClaimantProvider
     */
    protected $provider;

    /**
     * AccessControlBroker constructor.
     *
     * @param IClaimantProvider $provider
     */
    public function __construct(IClaimantProvider $provider)
    {
        $this->provider = $provider;
    }

    public function transferOwnership(IClaimable $claimable, $claimant)
    {

        if (!$claimant instanceof IClaimant) {
            $claimant = $this->lookUp($claimant);
        }

        return $claimable->grantOwnershipTo($claimant);
    }


    public function lookUp($claimantID)
    {
        $claimant = $this->provider->lookUp($claimantID);
        if (!$claimant) {
            throw new NotFound(sprintf('Unable to find claimant identified by %s', $claimantID));
        }

        return $claimant;
    }


}