<?php
/**
 * IResetPasswordRequest.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\Requestors\User;

interface IResetPasswordRequest
{
    /**
     * @param $token
     *
     * @return $this
     */
    public function withToken($token);

    public function getToken();

    public function withPlainPassword($password);

    public function getPlainPassword();
}