<?php
/**
 * ActivateRequestDTO.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Domain\Requestors\User\IActivateRequest;

class ActivateRequestDTO implements IActivateRequest
{

    public $token;

    public static function make()
    {
        return new self;
    }

    public function token()
    {
        return $this->token;
    }

    public function withToken($token)
    {
        $this->token = $token;

        return $this;
    }
}