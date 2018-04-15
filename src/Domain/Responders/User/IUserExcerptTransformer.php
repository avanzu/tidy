<?php
/**
 * IUserExcerptTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Responders\User;

use Tidy\Domain\Entities\User;

interface IUserExcerptTransformer
{
    /**
     * @param User $user
     *
     * @return IUserExcerpt
     */
    public function excerpt(User $user);
}