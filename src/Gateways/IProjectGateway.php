<?php
/**
 * IProjectGateway.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Gateways;


use Tidy\Entities\Project;

interface IProjectGateway
{
    /**
     * @return Project
     */
    public function make();

    /**
     * @param Project $project
     *
     * @return mixed
     */
    public function save($project);

    /**
     * @param $ownerId
     *
     * @return Project
     */
    public function makeForOwner($ownerId);
}