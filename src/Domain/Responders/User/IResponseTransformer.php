<?php
/**
 * ResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Responders\User;


use Tidy\Domain\Entities\User;

interface IResponseTransformer
{
    /**
     * @param User $user
     *
     * @return IResponse
     */
    public function transform(User $user);
}