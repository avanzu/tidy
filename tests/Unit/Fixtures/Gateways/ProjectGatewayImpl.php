<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Fixtures\Gateways;

use Tidy\Components\AccessControl\AccessControlBroker;
use Tidy\Components\Collection\Boundary;
use Tidy\Components\Collection\IPagedCollection;
use Tidy\Components\DataAccess\Comparison;
use Tidy\Components\Events\IDispatcher;
use Tidy\Domain\Entities\Project;
use Tidy\Domain\Gateways\ProjectGateway;
use Tidy\Domain\Repositories\IProjectRepository;
use Tidy\Tests\Unit\Fixtures\Entities\ProjectImpl;

class ProjectGatewayImpl extends ProjectGateway
{

    /**
     * @var IProjectRepository
     */
    protected $repository;

    /**
     * @var AccessControlBroker
     */
    protected $broker;

    public function __construct(IProjectRepository $repository, AccessControlBroker $broker, IDispatcher $dispatcher)
    {
        $this->broker     = $broker;
        $this->repository = $repository;
        parent::__construct($dispatcher);
    }


    protected function doSave(Project $project)
    {

    }

    /**
     * @param Boundary     $boundary
     * @param Comparison[] $criteria
     *
     * @return IPagedCollection
     */
    public function fetchCollection(Boundary $boundary, array $criteria = [])
    {
        return $this->repository->fetchCollection($boundary, $criteria);
    }

    /**
     * @param $projectId
     *
     * @return Project|null
     */
    public function find($projectId)
    {
        return $this->repository->find($projectId);
    }

    /**
     * @param $canonical
     *
     * @return Project|null
     */
    public function findByCanonical($canonical)
    {
        return $this->repository->findByCanonical($canonical);
    }

    /**
     * @return Project
     */
    public function make()
    {
        return new ProjectImpl();
    }

    /**
     * @param $ownerId
     *
     * @return Project
     */
    public function makeForOwner($ownerId)
    {
        $project = $this->make();
        $this->broker->transferOwnership($project, $ownerId);

        return $project;
    }

    /**
     * @param Comparison[] $criteria
     *
     * @return int
     */
    public function total(array $criteria = [])
    {
        return $this->repository->total($criteria);
    }
}