<?php
/**
 * ResetPasswordRequestDTO.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Domain\Requestors\User\IResetPasswordRequest;

class ResetPasswordRequestDTO implements IResetPasswordRequest
{
    protected $token;

    protected $plainPassword;

    /**
     * ResetPasswordRequestDTO constructor.
     *
     * @param $token
     * @param $plainPassword
     */
    public function __construct($token, $plainPassword)
    {
        $this->token         = $token;
        $this->plainPassword = $plainPassword;
    }


    public function plainPassword()
    {
        return $this->plainPassword;
    }

    public function token()
    {
        return $this->token;
    }



}