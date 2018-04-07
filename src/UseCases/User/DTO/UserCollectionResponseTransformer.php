<?php
/**
 * UserCollectionResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Responders\User\IUserCollectionResponse;
use Tidy\Responders\User\IUserCollectionResponseTransformer;
use Tidy\Responders\User\IUserResponseTransformer;
use Tidy\UseCases\User\DTO\UserResponseTransformer as ItemTransformer;

/**
 * Class UserCollectionResponseTransformer
 */
class UserCollectionResponseTransformer implements IUserCollectionResponseTransformer
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
     * @param IUserResponseTransformer $itemTransformer
     *
     * @return IUserResponseTransformer
     */
    public function replaceItemTransformer(IUserResponseTransformer $itemTransformer)
    {
        $previous              = $this->itemTransformer;
        $this->itemTransformer = $itemTransformer;

        return $previous;
    }

    /**
     * @param $items
     * @param $page
     * @param $pageSize
     * @param $itemsTotal
     *
     * @return IUserCollectionResponse
     */
    public function transform($items, $page, $pageSize, $itemsTotal)
    {
        $response             = new UserCollectionResponseDTO();
        $response->page       = $page;
        $response->pageSize   = $pageSize;
        $response->itemsTotal = $itemsTotal;
        $response->pagesTotal = ceil($itemsTotal / $pageSize);

        $response->items = [];
        while ($item = array_shift($items)) {
            $response->items[] = $this->itemTransformer->transform($item);
        }

        return $response;
    }
}