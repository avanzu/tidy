<?php
/**
 * ICreateProjectRequest.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Requestors\Project;

interface ICreateProjectRequest
{
    /**
     * @param $name
     *
     * @return ICreateProjectRequest
     */
    public function withName($name);

    /**
     * @param $description
     *
     * @return ICreateProjectRequest
     */
    public function withDescription($description);

    public function name();

    /**
     * @return mixed
     */
    public function description();

    /**
     * @param $owner
     *
     * @return ICreateProjectRequest
     */
    public function withOwnerId($owner);

    public function ownerId();
}