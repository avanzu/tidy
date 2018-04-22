<?php
/**
 * RecoverRequestDTO.php
 * Tidy
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Domain\Requestors\User\IRecoverRequest;

class RecoverRequestDTO implements IRecoverRequest
{
    public $userName;

    public static function make()
    {
        return new static;
    }

    public function userName()
    {
        return $this->userName;
    }

    public function withUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

}