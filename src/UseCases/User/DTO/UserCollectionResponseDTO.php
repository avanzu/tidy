<?php
/**
 * UserCollectionResponseDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Domain\Responders\CollectionResponse;
use Tidy\Domain\Responders\User\IUserCollectionResponse;
use Tidy\Domain\Responders\User\IUserResponse;

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

    /**
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->items);
    }
}