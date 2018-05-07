<?php
/**
 * ICollectionResponse.php
 * Tidy
 * Date: 22.04.18
 */
namespace Tidy\Domain\Responders\Project;

interface ICollectionResponse
{
    /**
     * @return IResponse[]|iterable
     */
    public function getItems();

    /**
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count();
}