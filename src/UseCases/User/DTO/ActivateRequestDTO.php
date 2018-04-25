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

    protected  $token;

    /**
     * ActivateRequestDTO constructor.
     *
     * @param $token
     */
    public function __construct($token) {
        $this->token = $token;
    }

    public function token()
    {
        return $this->token;
    }
}