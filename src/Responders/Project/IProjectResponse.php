<?php
/**
 * IProjectResponse.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Responders\Project;

use Tidy\Responders\User\IUserExcerpt;
use Tidy\UseCases\User\DTO\UserExcerptDTO;


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