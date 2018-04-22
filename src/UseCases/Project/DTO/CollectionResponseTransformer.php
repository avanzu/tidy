<?php
/**
 * CollectionResponseTransformer.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Components\Collection\IPagedCollection;
use Tidy\Domain\Responders\Project\ICollectionResponseTransformer;
use Tidy\Domain\Responders\Project\IResponseTransformer;

class CollectionResponseTransformer implements ICollectionResponseTransformer
{
    /**
     * @var IResponseTransformer
     */
    protected $itemTransformer;


    /**
     * CollectionResponseTransformer constructor.
     *
     * @param IResponseTransformer|null $itemTransformer
     */
    public function __construct(IResponseTransformer $itemTransformer = null)
    {
        $this->itemTransformer = $itemTransformer;
    }

    public function swapItemTransformer(IResponseTransformer $itemTransformer)
    {
        $previous              = $this->itemTransformer;
        $this->itemTransformer = $itemTransformer;

        return $previous;
    }

    protected function itemTransformer()
    {
        if( ! $this->itemTransformer) $this->itemTransformer = new ResponseTransformer();
        return $this->itemTransformer;
    }

    public function transform(IPagedCollection $collection)
    {

        $response        = new CollectionResponseDTO();
        $response->items = $collection->map(function ($item) { return $this->itemTransformer()->transform($item); });
        $response->pickBoundaries($collection);

        return $response;

    }
}