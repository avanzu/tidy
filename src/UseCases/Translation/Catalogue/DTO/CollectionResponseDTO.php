<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

use Tidy\Domain\Responders\CollectionResponse;
use Tidy\Domain\Responders\Translation\Catalogue\ICollectionResponse;

class CollectionResponseDTO extends CollectionResponse implements ICollectionResponse
{

    /**
     * @var \Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponse[]
     */
    public $items = [];

    /**
     * @return \Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponse[]
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