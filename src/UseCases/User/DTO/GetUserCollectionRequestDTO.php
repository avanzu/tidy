<?php
/**
 * GetUserCollectionRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Requestors\CollectionRequest;
use Tidy\Requestors\User\IGetUserCollectionRequest;

/**
 * Class GetUserCollectionRequestDTO
 */
class GetUserCollectionRequestDTO extends CollectionRequest implements IGetUserCollectionRequest
{


    public static function make() {
        return new static;
    }
}