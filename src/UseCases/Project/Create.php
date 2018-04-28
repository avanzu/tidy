<?php
/**
 * Create.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project;

use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Requestors\Project\ICreateRequest;
use Tidy\Domain\Responders\Project\IResponse;
use Tidy\Domain\Responders\Project\IResponseTransformer;
use Tidy\UseCases\Project\Traits\TItemResponder;

class Create
{
    use TItemResponder;


    /**
     * Create constructor.
     *
     * @param IProjectGateway      $projectGateway
     * @param IResponseTransformer $transformer
     */
    public function __construct(
        IProjectGateway $projectGateway,
        IResponseTransformer $transformer = null
    ) {
        $this->gateway     = $projectGateway;
        $this->transformer = $transformer;
    }

    /**
     * @param ICreateRequest $request
     *
     * @return IResponse
     */
    public function execute(ICreateRequest $request)
    {
        $project = $this->gateway->makeForOwner($request->ownerId());

        $project->setUp($request);

        $this->gateway->save($project);

        return $this->transformer()->transform($project);
    }


}