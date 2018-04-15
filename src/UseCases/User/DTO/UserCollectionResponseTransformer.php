<?php
/**
 * UserCollectionResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Components\Collection\IPagedCollection;
use Tidy\Components\Collection\PagedCollection;
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
    public function swapItemTransformer(IUserResponseTransformer $itemTransformer)
    {
        $previous              = $this->itemTransformer;
        $this->itemTransformer = $itemTransformer;

        return $previous;
    }

    /**
     *
     * @param IPagedCollection $collection
     *
     * @return UserCollectionResponseDTO
     */
    public function transform(IPagedCollection $collection)
    {
        $response             = new UserCollectionResponseDTO();
        $response->page       = $collection->getPage();
        $response->pageSize   = $collection->getPageSize();
        $response->itemsTotal = $collection->getTotal();
        $response->pagesTotal = $collection->getPagesTotal();
        $response->items      = $collection->map(function($item){ return $this->itemTransformer->transform($item); });

        return $response;
    }
}