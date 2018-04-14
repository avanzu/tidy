<?php
/**
 * RegisterUserRequestDTO.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User\DTO;


class RegisterUserRequestDTO extends CreateUserRequestDTO
{
    /**
     * @return RegisterUserRequestDTO
     */
    public static function make()
    {
        return new self;
    }
}