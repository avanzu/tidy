<?php
/**
 * UserCollectionResponseDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Responders\CollectionResponse;
use Tidy\Responders\User\IUserCollectionResponse;
use Tidy\Responders\User\IUserResponse;


/**
 * Class UserCollectionResponseDTO
 */
class UserCollectionResponseDTO extends CollectionResponse implements IUserCollectionResponse
{


    /**
     * @var IUserResponse[]
     */
    public $items;

    /**
     * @return IUserResponse[]
     */
    public function getItems()
    {
        return $this->items;
    }

}