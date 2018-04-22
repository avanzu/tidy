<?php
/**
 * LookUp.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project;


use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Requestors\Project\ILookUpRequest;
use Tidy\Domain\Responders\Project\IResponse;

class LookUp extends UseCaseProject
{


    /**
     * @param ILookUpRequest $request
     *
     * @return IResponse
     */
    public function execute(ILookUpRequest $request)
    {

        $project = $this->gateway->find($request->projectId());
        if (!$project) {
            throw new NotFound(sprintf('Unable to find project by identifier %s', $request->projectId()));
        }

        return $this->transformer()->transform($project);
    }


}