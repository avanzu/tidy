<?php
/**
 * Create.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project;

use Tidy\Components\AccessControl\AccessControlBroker;
use Tidy\Domain\Collections\Projects;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Requestors\Project\ICreateRequest;
use Tidy\Domain\Responders\Project\IResponse;
use Tidy\Domain\Responders\Project\IResponseTransformer;
use Tidy\UseCases\Project\Traits\TItemResponder;

class Create
{
    use TItemResponder;

    /**
     * @var AccessControlBroker
     */
    private $broker;


    /**
     * Create constructor.
     *
     * @param IProjectGateway      $projectGateway
     * @param AccessControlBroker  $broker
     * @param IResponseTransformer $transformer
     */
    public function __construct(
        IProjectGateway $projectGateway,
        AccessControlBroker $broker,
        IResponseTransformer $transformer = null
    ) {
        $this->gateway     = $projectGateway;
        $this->transformer = $transformer;
        $this->broker      = $broker;
    }

    /**
     * @param ICreateRequest $request
     *
     * @return IResponse
     */
    public function execute(ICreateRequest $request)
    {
        $project = $this->gateway->make();
        $owner   = $this->broker->lookUp($request->ownerId());

        $project->setUp($request, new Projects($this->gateway));
        $project->grantOwnershipTo($owner);

        $this->gateway->save($project);

        return $this->transformer()->transform($project);
    }

    public function setAccessControlBroker(AccessControlBroker $broker) {
        $this->broker = $broker;
    }


}