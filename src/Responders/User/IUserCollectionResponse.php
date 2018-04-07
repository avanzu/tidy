<?php
/**
 * IUserCollectionResponse.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Responders\User;


/**
 * Class UserCollectionResponseDTO
 */
interface IUserCollectionResponse
{
    /**
     * @return int
     */
    public function getPage();

    /**
     * @return int
     */
    public function getPageSize();

    /**
     * @return IUserResponse[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function pagesTotal();

    /**
     * @return int
     */
    public function getTotal();
}