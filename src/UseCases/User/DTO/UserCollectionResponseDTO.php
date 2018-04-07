<?php
/**
 * UserCollectionResponseDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Responders\User\UserResponse;


/**
 * Class UserCollectionResponseDTO
 */
class UserCollectionResponseDTO
{

    /**
     * @var
     */
    public $page;
    /**
     * @var
     */
    public $pageSize;
    /**
     * @var
     */
    public $items;

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @return UserResponse
     */
    public function getItems() {
        return $this->items;
    }
}