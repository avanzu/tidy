<?php
/**
 * CollectionResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Components\Collection\IPagedCollection;
use Tidy\Domain\Responders\User\ICollectionResponseTransformer;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\UseCases\User\DTO\ResponseTransformer as ItemTransformer;

/**
 * Class CollectionResponseTransformer
 */
class CollectionResponseTransformer implements ICollectionResponseTransformer
{

    /**
     * @var ResponseTransformer
     */
    private $itemTransformer;

    /**
     * CollectionResponseTransformer constructor.
     *
     * @param IResponseTransformer|null $itemTransformer
     */
    public function __construct(IResponseTransformer $itemTransformer = null)
    {
        $this->itemTransformer = $itemTransformer;
    }

    /**
     * @param IResponseTransformer $itemTransformer
     *
     * @return IResponseTransformer
     */
    public function swapItemTransformer(IResponseTransformer $itemTransformer)
    {
        $previous              = $this->itemTransformer;
        $this->itemTransformer = $itemTransformer;

        return $previous;
    }

    /**
     *
     * @param IPagedCollection $collection
     *
     * @return CollectionResponseDTO
     */
    public function transform(IPagedCollection $collection)
    {
        $response        = new CollectionResponseDTO();
        $response->items = $collection->map(function ($item) { return $this->itemTransformer()->transform($item); });
        $response->pickBoundaries($collection);

        return $response;
    }

    protected function itemTransformer()
    {
        if (!$this->itemTransformer) {
            $this->itemTransformer = new ItemTransformer();
        }

        return $this->itemTransformer;
    }
}