<?php
/**
 * ICollectionResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Responders\User;

use Tidy\Components\Collection\IPagedCollection;

/**
 * Class CollectionResponseTransformer
 */
interface ICollectionResponseTransformer
{
    /**
     *
     * @param IPagedCollection $collection
     *
     * @return ICollectionResponse
     */
    public function transform(IPagedCollection $collection);

    /**
     * @param IResponseTransformer $itemTransformer
     *
     * @return IResponseTransformer
     */
    public function swapItemTransformer(IResponseTransformer $itemTransformer);
}