<?php
/**
 * OwnerExcerptTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\AccessControl\DTO;


use Tidy\Components\AccessControl\IClaimant;
use Tidy\Domain\Responders\AccessControl\IOwnerExcerpt;
use Tidy\Domain\Responders\AccessControl\IOwnerExcerptTransformer;

class OwnerExcerptTransformer implements IOwnerExcerptTransformer
{

    /**
     * @param IClaimant $claimant
     *
     * @return IOwnerExcerpt
     */
    public function excerpt(IClaimant $claimant = null)
    {
        return $this->transformClaimant(new OwnerExcerptDTO(), $claimant);
    }

    /**
     * @param IClaimant $claimant
     * @param           $excerpt
     *
     * @return
     */
    private function transformClaimant($excerpt, IClaimant $claimant = null)
    {
        if (!$claimant) {
            return $excerpt;
        }
        $excerpt->name     = $claimant->getName();
        $excerpt->identity = $claimant->identify();

        return $excerpt;
    }
}