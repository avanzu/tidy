<?php
/**
 * IProjectResponse.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Responders\Project;

use Tidy\Domain\Responders\AccessControl\IOwnerExcerpt;


/**
 * Class ProjectResponseDTO
 */
interface IProjectResponse
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
}