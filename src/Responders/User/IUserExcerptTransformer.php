<?php
/**
 * IUserExcerptTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Responders\User;

use Tidy\Entities\User;

interface IUserExcerptTransformer
{
    /**
     * @param User $user
     *
     * @return IUserExcerpt
     */
    public function excerpt(User $user);
}