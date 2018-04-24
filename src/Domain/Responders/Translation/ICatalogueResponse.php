<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Responders\Translation;

use Tidy\UseCases\Translation\DTO\Excerpt;

interface ICatalogueResponse
{
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getCanonical();

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getSourceLanguage();

    /**
     * @return mixed
     */
    public function getSourceCulture();

    /**
     * @return mixed
     */
    public function getTargetLanguage();

    /**
     * @return mixed
     */
    public function getTargetCulture();

    /**
     * @return Excerpt
     */
    public function getProject();

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