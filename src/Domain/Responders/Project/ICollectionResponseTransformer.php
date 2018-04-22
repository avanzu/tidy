<?php
/**
 * ICollectionResponseTransformer.php
 * Tidy
 * Date: 22.04.18
 */
namespace Tidy\Domain\Responders\Project;

use Tidy\Components\Collection\IPagedCollection;

interface ICollectionResponseTransformer
{
    public function swapItemTransformer(IResponseTransformer $itemTransformer);

    public function transform(IPagedCollection $collection);
}