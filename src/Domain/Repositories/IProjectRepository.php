<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Domain\Repositories;

use Tidy\Components\Collection\Boundary;
use Tidy\Components\Collection\IPagedCollection;
use Tidy\Domain\Entities\Project;

interface IProjectRepository
{

    /**
     * @param $criteria
     *
     * @return int
     */
    public function total($criteria);

    /**
     * @param Boundary $boundary
     * @param array    $criteria
     *
     * @return IPagedCollection
     */
    public function fetchCollection(Boundary $boundary, array $criteria);

    /**
     * @param $projectId
     *
     * @return Project|null
     */
    public function find($projectId);

    /**
     * @param $canonical
     *
     * @return Project|null
     */
    public function findByCanonical($canonical);
}