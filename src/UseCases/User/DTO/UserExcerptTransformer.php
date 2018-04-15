<?php
/**
 * UserExcerptTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Entities\User;
use Tidy\Responders\User\IUserExcerpt;
use Tidy\Responders\User\IUserExcerptTransformer;

class UserExcerptTransformer implements IUserExcerptTransformer
{

    /**
     * @param User $user
     *
     * @return IUserExcerpt
     */
    public function transform(User $user)
    {
        $excerpt           = new UserExcerptDTO();
        $excerpt->userName = $user->getUserName();
        $excerpt->id       = $user->getId();

        return $excerpt;
    }
}