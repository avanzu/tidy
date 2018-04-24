<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

use Tidy\Domain\Responders\CollectionResponse;

class CollectionResponseDTO extends CollectionResponse
{

    /**
     * @var CatalogueResponseDTO[]
     */
    public $items = [];

    /**
     * @return CatalogueResponseDTO[]
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