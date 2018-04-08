<?php
/**
 * IUserCollectionResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Responders\User;

use Tidy\UseCases\User\DTO\UserCollectionResponseDTO;
use Tidy\Util\PagedCollection;


/**
 * Class UserCollectionResponseTransformer
 */
interface IUserCollectionResponseTransformer
{
    /**
     *
     * @param PagedCollection $collection
     *
     * @return IUserCollectionResponse
     */
    public function transform(PagedCollection $collection);

    /**
     * @param IUserResponseTransformer $itemTransformer
     *
     * @return IUserResponseTransformer
     */
    public function swapItemTransformer(IUserResponseTransformer $itemTransformer);
}