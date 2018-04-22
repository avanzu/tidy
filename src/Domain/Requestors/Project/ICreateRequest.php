<?php
/**
 * ICreateRequest.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Requestors\Project;

interface ICreateRequest
{
    /**
     * @param $name
     *
     * @return ICreateRequest
     */
    public function withName($name);

    /**
     * @param $description
     *
     * @return ICreateRequest
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
     * @return ICreateRequest
     */
    public function withOwnerId($owner);

    public function ownerId();
}