<?php
/**
 * GetProject.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project;


use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Requestors\Project\IGetProjectRequest;
use Tidy\Domain\Responders\Project\IProjectResponse;

class GetProject extends UseCaseProject
{


    /**
     * @param IGetProjectRequest $request
     *
     * @return IProjectResponse
     */
    public function execute(IGetProjectRequest $request)
    {

        $project = $this->gateway->find($request->getProjectId());
        if (!$project) {
            throw new NotFound(sprintf('Unable to find project by identifier %s', $request->getProjectId()));
        }

        return $this->transformer->transform($project);
    }


}