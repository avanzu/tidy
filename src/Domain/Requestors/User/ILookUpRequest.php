<?php
/**
 * LookUpRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Requestors\User;


interface ILookUpRequest
{
    /**
     * @return int
     */
    public function userId();
}