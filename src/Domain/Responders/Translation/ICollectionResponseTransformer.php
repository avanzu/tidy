<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Responders\Translation;

use Tidy\Components\Collection\IPagedCollection;
use Tidy\UseCases\Translation\DTO\CollectionResponseDTO;

interface ICollectionResponseTransformer
{
    public function swapItemTransformer(ICatalogueResponseTransformer $itemTransformer);

    /**
     * @param IPagedCollection $collection
     *
     * @return ICollectionResponse
     */
    public function transform(IPagedCollection $collection);
}