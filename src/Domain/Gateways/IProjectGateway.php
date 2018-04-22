<?php
/**
 * IProjectGateway.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Gateways;


use Tidy\Components\Collection\IPagedCollection;
use Tidy\Domain\Entities\Project;

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

    /**
     * @param $projectId
     *
     * @return Project|null
     */
    public function find($projectId);

    /**
     * @param      $page
     * @param      $pageSize
     * @param null $criteria
     *
     * @return IPagedCollection
     */
    public function fetchCollection($page, $pageSize,  $criteria = null);

    /**
     * @return int
     */
    public function total();

}