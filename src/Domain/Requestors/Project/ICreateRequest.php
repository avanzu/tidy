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
     * @return mixed
     */
    public function name();

    /**
     * @return mixed
     */
    public function description();

    /**
     * @return mixed
     */
    public function ownerId();
}