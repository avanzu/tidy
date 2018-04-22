<?php
/**
 * IActivateRequest.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Domain\Requestors\User;

interface IActivateRequest
{
    public function withToken($token);

    public function token();
}