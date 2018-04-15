<?php
/**
 * UserResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Responders\User;


use Tidy\Domain\Entities\User;

interface IUserResponseTransformer
{
    /**
     * @param User $user
     *
     * @return IUserResponse
     */
    public function transform(User $user);
}