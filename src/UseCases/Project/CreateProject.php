<?php
/**
 * CreateProject.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project;


use Tidy\Gateways\IProjectGateway;
use Tidy\UseCases\Project\DTO\CreateProjectRequestDTO;
use Tidy\UseCases\Project\DTO\ProjectResponseDTO;
use Tidy\UseCases\Project\DTO\ProjectResponseTransformer;

class CreateProject
{

    /**
     * @var IProjectGateway
     */
    protected $projectGateway;
    /**
     * @var ProjectResponseTransformer
     */
    protected $transformer;

    public function setResponseTransformer($transformer) {
        $this->transformer = $transformer;
    }

    public function execute(CreateProjectRequestDTO $request) {

        $project = $this->projectGateway->make();
        $project
            ->setName($request->getName())
            ->setDescription($request->getDescription());

        $this->projectGateway->save($project);

        return $this->transformer->transform($project);
    }

    public function setProjectGateway($gateway) {
        $this->projectGateway = $gateway;
    }
}