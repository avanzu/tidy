<?php
/**
 * UserResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Entities\User;
use Tidy\Responders\User\IUserResponse;
use Tidy\Responders\User\IUserResponseTransformer as Transformer;

/**
 * Class UserResponseTransformer
 */
class UserResponseTransformer implements Transformer
{

    /**
     * @param User $user
     *
     * @return IUserResponse
     */
    public function transform(User $user)
    {
        $response           = new UserResponseDTO();
        $response->id       = $user->getId();
        $response->userName = $user->getUserName();
        $response->eMail    = $user->getEMail();
        $response->password = $user->getPassword();
        $response->enabled  = $user->isEnabled();
        $response->token    = $user->getToken();

        return $response;
    }
}