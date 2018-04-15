<?php
/**
 * IUserExcerptTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Responders\User;

use Tidy\Entities\User;
use Tidy\UseCases\User\DTO\UserExcerptDTO;

interface IUserExcerptTransformer
{
    /**
     * @param User $user
     *
     * @return IUserExcerpt
     */
    public function transform(User $user);
}