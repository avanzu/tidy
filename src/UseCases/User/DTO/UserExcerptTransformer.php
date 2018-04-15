<?php
/**
 * UserExcerptTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Entities\User;

class UserExcerptTransformer
{

    /**
     * @param User $user
     *
     * @return UserExcerptDTO
     */
    public function transform(User $user)
    {
        $excerpt           = new UserExcerptDTO();
        $excerpt->userName = $user->getUserName();
        $excerpt->id       = $user->getId();

        return $excerpt;
    }
}