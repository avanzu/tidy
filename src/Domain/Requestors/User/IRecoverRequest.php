<?php
/**
 * IRecoverRequest.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\Domain\Requestors\User;

interface IRecoverRequest
{
    public function withUserName($userName);

    public function userName();
}