<?php
/**
 * UserCollectionResponseTransformer.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Responders\User\UserResponseTransformer;

class UserCollectionResponseTransformer
{

    /**
     * @var UserResponseTransformer
     */
    private $itemTransformer;

    /**
     * UserCollectionResponseTransformer constructor.
     *
     * @param UserResponseTransformer $itemTransformer
     */
    public function __construct(UserResponseTransformer $itemTransformer) {
        $this->itemTransformer = $itemTransformer;
    }


    public function setItemTransformer(UserResponseTransformer $itemTransformer) {
        $this->itemTransformer = $itemTransformer;
    }

    public function transform($items, $page, $pageSize) {
        $response           = new UserCollectionResponseDTO();
        $response->page     = $page;
        $response->pageSize = $pageSize;
        $response->items    = [];
        while ($item = array_shift($items))
            $response->items[] = $this->itemTransformer->transform($item);

        return $response;
    }
}