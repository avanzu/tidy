<?php
/**
 * GetProject.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project;


use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Responders\Project\IProjectResponse;
use Tidy\Domain\Responders\Project\IProjectResponseTransformer;
use Tidy\UseCases\Project\DTO\GetProjectRequestDTO;

class GetProject
{
    /**
     * @var IProjectGateway
     */
    protected $gateway;
    /**
     * @var IProjectResponseTransformer
     */
    protected $transformer;

    /**
     * GetProject constructor.
     *
     * @param IProjectGateway             $gateway
     * @param IProjectResponseTransformer $transformer
     */
    public function __construct(IProjectGateway $gateway, IProjectResponseTransformer $transformer)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }

    /**
     * @param GetProjectRequestDTO $request
     *
     * @return IProjectResponse
     */
    public function execute(GetProjectRequestDTO $request)
    {

        $project = $this->gateway->find($request->getProjectId());
        if (!$project) {
            throw new NotFound(sprintf('Unable to find project by identifier %s', $request->getProjectId()));
        }

        return $this->transformer->transform($project);
    }


}