<?php
/**
 * IUserCollectionResponse.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Responders\User;

use Tidy\Domain\Responders\ICollectionResponse;


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