<?php
/**
 * IUserCollectionResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Responders\User;

use Tidy\UseCases\User\DTO\UserCollectionResponseDTO;


/**
 * Class UserCollectionResponseTransformer
 */
interface IUserCollectionResponseTransformer
{
    /**
     * @param $items
     * @param $page
     * @param $pageSize
     * @param $itemsTotal
     *
     * @return IUserCollectionResponse
     */
    public function transform($items, $page, $pageSize, $itemsTotal);

    /**
     * @param IUserResponseTransformer $itemTransformer
     *
     * @return IUserResponseTransformer
     */
    public function replaceItemTransformer(IUserResponseTransformer $itemTransformer);
}