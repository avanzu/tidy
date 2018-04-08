<?php
/**
 * ICollectionResponse.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\Responders;


interface ICollectionResponse
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
     * @return int
     */
    public function pagesTotal();

    /**
     * @return int
     */
    public function getTotal();
}