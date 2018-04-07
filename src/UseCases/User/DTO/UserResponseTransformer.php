<?php
/**
 * UserResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Entities\User;
use Tidy\Responders\User\UserResponse;
use Tidy\Responders\User\UserResponseTransformer as Transformer;

class UserResponseTransformer implements Transformer
{

    /**
     * @param User $user
     *
     * @return UserResponse
     */
    public function transform(User $user)
    {
        $response           = new UserResponseDTO();

        $response->id       = $user->getId();
        $response->userName = $user->getUserName();

        return $response;
    }
}