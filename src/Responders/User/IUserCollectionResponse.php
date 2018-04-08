<?php
/**
 * IUserCollectionResponse.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Responders\User;

use Tidy\Responders\ICollectionResponse;


/**
 * Class UserCollectionResponseDTO
 */
interface IUserCollectionResponse extends ICollectionResponse
{

    /**
     * @return IUserResponse[]
     */
    public function getItems();
}