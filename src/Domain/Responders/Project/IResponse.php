<?php
/**
 * IResponse.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Responders\Project;

use Tidy\Domain\Responders\AccessControl\IOwnerExcerpt;

/**
 * Class ResponseDTO
 */
interface IResponse
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getCanonical();

    /**
     * @return IOwnerExcerpt
     */
    public function getOwner();

    /**
     * @return string
     */
    public function path();
}