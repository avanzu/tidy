<?php
/**
 * IResetPasswordRequest.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\Domain\Requestors\User;

interface IResetPasswordRequest
{
    /**
     * @param $token
     *
     * @return $this
     */
    public function withToken($token);

    public function token();

    public function withPlainPassword($password);

    public function plainPassword();
}