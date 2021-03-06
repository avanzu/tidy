<?php
/**
 * IProjectGateway.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Gateways;

use Tidy\Components\Collection\Boundary;
use Tidy\Components\Collection\IPagedCollection;
use Tidy\Components\DataAccess\Comparison;
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
    public function save(Project $project);

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
     * @param Boundary     $boundary
     * @param Comparison[] $criteria
     *
     * @return IPagedCollection
     */
    public function fetchCollection(Boundary $boundary, array $criteria = []);

    /**
     * @param Comparison[] $criteria
     *
     * @return int
     */
    public function total(array $criteria = []);

    /**
     * @param $canonical
     *
     * @return Project|null
     */
    public function findByCanonical($canonical);

}