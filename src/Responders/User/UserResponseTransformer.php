<?php
/**
 * UserResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Responders\User;


use Tidy\Entities\User;

interface UserResponseTransformer
{
    /**
     * @param User $user
     *
     * @return UserResponse
     */
    public function transform(User $user);
}