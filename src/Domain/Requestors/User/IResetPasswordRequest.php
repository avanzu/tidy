<?php
/**
 * IResetPasswordRequest.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\Domain\Requestors\User;

interface IResetPasswordRequest
{

    public function token();

    public function plainPassword();
}