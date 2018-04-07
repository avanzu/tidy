<?php
/**
 * UserCollectionResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Responders\User\UserResponseTransformer;
use Tidy\UseCases\User\DTO\UserResponseTransformer as ItemTransformer;

/**
 * Class UserCollectionResponseTransformer
 */
class UserCollectionResponseTransformer
{

    /**
     * @var UserResponseTransformer
     */
    private $itemTransformer;

    /**
     * UserCollectionResponseTransformer constructor.
     *
     */
    public function __construct()
    {
        $this->itemTransformer = new ItemTransformer();
    }

    /**
     * @param $items
     * @param $page
     * @param $pageSize
     * @param $itemsTotal
     *
     * @return UserCollectionResponseDTO
     */
    public function transform($items, $page, $pageSize, $itemsTotal)
    {
        $response             = new UserCollectionResponseDTO();
        $response->page       = $page;
        $response->pageSize   = $pageSize;
        $response->itemsTotal = $itemsTotal;
        $response->pagesTotal = ceil($itemsTotal/$pageSize);

        $response->items    = [];
        while ($item = array_shift($items)) {
            $response->items[] = $this->itemTransformer->transform($item);
        }

        return $response;
    }


    /**
     * @param UserResponseTransformer $itemTransformer
     *
     * @return UserResponseTransformer
     */
    public function replaceItemTransformer(UserResponseTransformer $itemTransformer)
    {
        $previous              = $this->itemTransformer;
        $this->itemTransformer = $itemTransformer;

        return $previous;
    }
}