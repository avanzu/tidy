<?php
/**
 * ICollectionResponse.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Responders\User;

use Tidy\Domain\Responders\ICollectionResponse as Response;


/**
 * Class CollectionResponseDTO
 */
interface ICollectionResponse extends Response
{

    /**
     * @return IResponse[]
     */
    public function getItems();
}