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
    protected  $userName;

    /**
     * RecoverRequestDTO constructor.
     *
     * @param $userName
     */
    public function __construct($userName) { $this->userName = $userName; }


    public function userName()
    {
        return $this->userName;
    }

}