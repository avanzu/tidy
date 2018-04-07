<?php
/**
 * IGetUserCollectionRequestBuilder.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Requestors\User;

use Tidy\UseCases\User\DTO\GetUserCollectionRequestDTO;


/**
 * Class GetUserCollectionRequestBuilder
 */
interface IGetUserCollectionRequestBuilder
{
    /**
     * @return $this
     */
    public function create();

    /**
     * @return IGetUserCollectionRequest
     */
    public function build();

    /**
     * @param $page
     *
     * @return $this
     */
    public function fromPage($page);

    /**
     * @param $pageSize
     *
     * @return $this
     */
    public function withPageSize($pageSize);
}