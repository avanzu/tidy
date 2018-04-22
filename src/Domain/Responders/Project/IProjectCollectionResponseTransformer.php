<?php
/**
 * IProjectCollectionResponseTransformer.php
 * Tidy
 * Date: 22.04.18
 */
namespace Tidy\Domain\Responders\Project;

use Tidy\Components\Collection\IPagedCollection;

interface IProjectCollectionResponseTransformer
{
    public function swapItemTransformer(IProjectResponseTransformer $itemTransformer);

    public function transform(IPagedCollection $collection);
}