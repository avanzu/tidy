<?php
/**
 * IOwnerExcerptTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Responders\AccessControl;

use Tidy\Components\AccessControl\IClaimant;

interface IOwnerExcerptTransformer
{
    /**
     * @param IClaimant $claimant
     *
     * @return IOwnerExcerpt
     */
    public function excerpt(IClaimant $claimant);
}