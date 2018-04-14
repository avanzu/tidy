<?php
/**
 * RegisterUser.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\UseCases\User\DTO\RegisterUserRequestDTO;
use Tidy\UseCases\User\DTO\UserResponseDTO;

class RegisterUser extends GenericUseCase
{

    public function execute(RegisterUserRequestDTO $request) {

        return new UserResponseDTO();
    }
}