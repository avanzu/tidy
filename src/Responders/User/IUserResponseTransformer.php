<?php
/**
 * UserResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Responders\User;


use Tidy\Entities\User;

interface IUserResponseTransformer
{
    /**
     * @param User $user
     *
     * @return IUserResponse
     */
    public function transform(User $user);
}