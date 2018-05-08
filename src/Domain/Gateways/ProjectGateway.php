<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Domain\Gateways;

use Tidy\Components\Events\IDispatcher;
use Tidy\Components\Events\TBroadcast;
use Tidy\Domain\Entities\Project;

abstract  class ProjectGateway implements IProjectGateway
{

    use TBroadcast;

    /**
     * UserGateway constructor.
     *
     * @param IDispatcher $dispatcher
     */
    public function __construct(IDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Project $project
     *
     * @return mixed|void
     */
    public function save(Project $project)
    {
        $this->doSave($project);
        $this->broadcast($project);
    }



    abstract protected function doSave(Project $project);

}