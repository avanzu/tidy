<?php
/**
 * CollectionResponseDTO.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Domain\Responders\CollectionResponse;
use Tidy\Domain\Responders\Project\ICollectionResponse;
use Tidy\Domain\Responders\Project\IResponse;

class CollectionResponseDTO extends CollectionResponse implements ICollectionResponse
{

    /**
     * @var IResponse[]
     */
    public $items = [];

    /**
     * @return IResponse[]
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