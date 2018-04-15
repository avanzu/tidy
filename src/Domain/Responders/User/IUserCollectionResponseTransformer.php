<?php
/**
 * IUserCollectionResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Responders\User;

use Tidy\Components\Collection\IPagedCollection;


/**
 * Class UserCollectionResponseTransformer
 */
interface IUserCollectionResponseTransformer
{
    /**
     *
     * @param IPagedCollection $collection
     *
     * @return IUserCollectionResponse
     */
    public function transform(IPagedCollection $collection);

    /**
     * @param IUserResponseTransformer $itemTransformer
     *
     * @return IUserResponseTransformer
     */
    public function swapItemTransformer(IUserResponseTransformer $itemTransformer);
}