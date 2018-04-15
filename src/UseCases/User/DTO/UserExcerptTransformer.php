<?php
/**
 * UserExcerptTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Domain\Entities\User;
use Tidy\Domain\Responders\User\IUserExcerpt;
use Tidy\Domain\Responders\User\IUserExcerptTransformer;

class UserExcerptTransformer implements IUserExcerptTransformer
{

    /**
     * @param User $user
     *
     * @return IUserExcerpt
     */
    public function excerpt(User $user)
    {
        $excerpt           = new UserExcerptDTO();
        $excerpt->userName = $user->getUserName();
        $excerpt->id       = $user->getId();

        return $excerpt;
    }
}