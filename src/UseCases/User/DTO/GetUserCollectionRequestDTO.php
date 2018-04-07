<?php
/**
 * GetUserCollectionRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Requestors\CollectionRequest;

/**
 * Class GetUserCollectionRequestDTO
 */
class GetUserCollectionRequestDTO implements CollectionRequest
{
    /**
     * @var int
     */
    public $page;
    /**
     * @var int
     */
    public $pageSize;

    /**
     * @return mixed
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

}