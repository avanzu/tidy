<?php
/**
 * UserCollectionResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Components\Collection\IPagedCollection;
use Tidy\Domain\Responders\User\IUserCollectionResponseTransformer;
use Tidy\Domain\Responders\User\IUserResponseTransformer;
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
        $response->items      = $collection->map(function ($item) { return $this->itemTransformer->transform($item); });
        $response->pickBoundaries($collection);

        return $response;
    }
}