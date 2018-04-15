<?php
/**
 * IProjectResponse.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Responders\Project;

use Tidy\Domain\Responders\User\IUserExcerpt;


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
     * @return IUserExcerpt
     */
    public function getOwner();
}