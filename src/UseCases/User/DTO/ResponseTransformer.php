<?php
/**
 * ResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Domain\Entities\User;
use Tidy\Domain\Responders\User\IResponse;
use Tidy\Domain\Responders\User\IResponseTransformer as Transformer;

/**
 * Class ResponseTransformer
 */
class ResponseTransformer implements Transformer
{

    /**
     * @param User $user
     *
     * @return IResponse
     */
    public function transform(User $user)
    {
        $response = new ResponseDTO();
        $this
            ->mapUser($user, $response)
            ->mapProfile($user, $response)
        ;

        return $response;
    }

    /**
     * @param User $user
     * @param      $response
     *
     * @return ResponseTransformer
     */
    private function mapProfile(User $user, $response)
    {
        if (!$profile = $user->getProfile()) {
            return $this;
        }
        $response->firstName = $profile->getFirstName();
        $response->lastName  = $profile->getLastName();
        return $this;
    }

    /**
     * @param User $user
     * @param      $response
     *
     * @return ResponseTransformer
     */
    private function mapUser(User $user, $response)
    {
        $response->id       = $user->getId();
        $response->userName = $user->getUserName();
        $response->eMail    = $user->getEMail();
        $response->password = $user->getPassword();
        $response->enabled  = $user->isEnabled();
        $response->token    = $user->getToken();
        $response->path     = $user->path();

        return $this;
    }
}