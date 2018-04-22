<?php
/**
 * ProjectCollectionResponseTransformer.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Components\Collection\IPagedCollection;
use Tidy\Domain\Responders\Project\IProjectCollectionResponseTransformer;
use Tidy\Domain\Responders\Project\IProjectResponseTransformer;

class ProjectCollectionResponseTransformer implements IProjectCollectionResponseTransformer
{
    /**
     * @var IProjectResponseTransformer
     */
    protected $itemTransformer;


    /**
     * ProjectCollectionResponseTransformer constructor.
     *
     * @param IProjectResponseTransformer|null $itemTransformer
     */
    public function __construct(IProjectResponseTransformer $itemTransformer = null)
    {
        $this->itemTransformer = $itemTransformer;
    }

    public function swapItemTransformer(IProjectResponseTransformer $itemTransformer)
    {
        $previous              = $this->itemTransformer;
        $this->itemTransformer = $itemTransformer;

        return $previous;
    }

    protected function itemTransformer()
    {
        if( ! $this->itemTransformer) $this->itemTransformer = new ProjectResponseTransformer();
        return $this->itemTransformer;
    }

    public function transform(IPagedCollection $collection)
    {

        $response        = new ProjectCollectionResponseDTO();
        $response->items = $collection->map(function ($item) { return $this->itemTransformer()->transform($item); });
        $response->pickBoundaries($collection);

        return $response;

    }
}