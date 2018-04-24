<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

use Tidy\Components\Collection\IPagedCollection;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Responders\Translation\ICatalogueResponseTransformer;

class CollectionResponseTransformer
{

    /**
     * @var ICatalogueResponseTransformer
     */
    protected $itemTransformer;

    /**
     * CollectionResponseTransformer constructor.
     *
     * @param ICatalogueResponseTransformer $itemTransformer
     */
    public function __construct(ICatalogueResponseTransformer $itemTransformer = null)
    {
        $this->itemTransformer = $itemTransformer;
    }


    public function swapItemTransformer(ICatalogueResponseTransformer $itemTransformer)
    {
        $previous              = $this->itemTransformer;
        $this->itemTransformer = $itemTransformer;

        return $previous;

    }

    /**
     * @param IPagedCollection $collection
     *
     * @return CollectionResponseDTO
     */
    public function transform(IPagedCollection $collection)
    {
        $response = new CollectionResponseDTO();
        $response->pickBoundaries($collection);
        $response->items = $collection->map(
            function (TranslationCatalogue $catalogue) {
                return $this->itemTransformer()->transform($catalogue);
            }
        );

        return $response;
    }

    protected function itemTransformer()
    {
        if (!$this->itemTransformer) {
            $this->itemTransformer = new CatalogueResponseTransformer();
        }

        return $this->itemTransformer;
    }


}