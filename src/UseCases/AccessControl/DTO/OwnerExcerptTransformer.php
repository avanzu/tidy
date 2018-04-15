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
    public function excerpt(IClaimant $claimant)
    {
        $excerpt           = new OwnerExcerptDTO();
        $excerpt->name     = $claimant->getName();
        $excerpt->identity = $claimant->identify();

        return $excerpt;
    }
}