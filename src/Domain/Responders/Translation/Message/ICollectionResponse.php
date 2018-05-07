<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Responders\Translation\Message;

use Tidy\Domain\Responders\ICollectionResponse as BaseCollectionResponse;

interface ICollectionResponse extends BaseCollectionResponse
{
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

    /**
     * @return ITranslationResponse[]|iterable
     */
    public function items();
}