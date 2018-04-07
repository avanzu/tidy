<?php
/**
 * GetUserCollectionRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Requestors\User\IGetUserCollectionRequest;

/**
 * Class GetUserCollectionRequestDTO
 */
class GetUserCollectionRequestDTO implements IGetUserCollectionRequest
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

}