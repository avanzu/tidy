<?php
/**
 * ProjectCollectionResponseTransformer.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Components\Collection\IPagedCollection;
use Tidy\Domain\Responders\Project\IProjectResponseTransformer;

class ProjectCollectionResponseTransformer
{
    /**
     * @var IProjectResponseTransformer
     */
    protected $itemTransformer;


    /**
     * ProjectCollectionResponseTransformer constructor.
     */
    public function __construct()
    {
        $this->itemTransformer = new ProjectResponseTransformer();
    }

    public function swapItemTransformer(IProjectResponseTransformer $itemTransformer)
    {
        $previous              = $this->itemTransformer;
        $this->itemTransformer = $itemTransformer;

        return $previous;
    }

    public function transform(IPagedCollection $collection) {

        $response = new ProjectCollectionResponseDTO();
        $response->page       = $collection->getPage();
        $response->pageSize   = $collection->getPageSize();
        $response->itemsTotal = $collection->getTotal();
        $response->pagesTotal = $collection->getPagesTotal();
        $response->items      = $collection->map(function ($item) { return $this->itemTransformer->transform($item); });

        return $response;

    }
}