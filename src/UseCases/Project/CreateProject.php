<?php
/**
 * CreateProject.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project;


use Tidy\Components\Normalisation\ITextNormaliser;
use Tidy\Gateways\IProjectGateway;
use Tidy\Gateways\IUserGateway;
use Tidy\Requestors\Project\ICreateProjectRequest;
use Tidy\Responders\Project\IProjectResponseTransformer;
use Tidy\UseCases\Project\DTO\CreateProjectRequestDTO;
use Tidy\UseCases\Project\DTO\ProjectResponseTransformer;

class CreateProject
{

    /**
     * @var IProjectGateway
     */
    protected $projectGateway;
    /**
     * @var IProjectResponseTransformer
     */
    protected $transformer;
    /**
     * @var ITextNormaliser
     */
    protected $normaliser;
    /**
     * @var IUserGateway
     */
    protected $userGateway;

    public function setResponseTransformer($transformer)
    {
        $this->transformer = $transformer;
    }

    public function execute(ICreateProjectRequest $request)
    {

        $project   = $this->projectGateway->make();
        $owner     = $this->userGateway->find($request->getOwnerId());
        $canonical = $this->normaliser->transform($request->getName());
        $project
            ->setName($request->getName())
            ->setDescription($request->getDescription())
            ->setCanonical($canonical)
            ->setOwner($owner)
        ;

        $this->projectGateway->save($project);

        return $this->transformer->transform($project);
    }

    public function setProjectGateway($gateway)
    {
        $this->projectGateway = $gateway;
    }

    public function setNormaliser($normaliser)
    {
        $this->normaliser = $normaliser;
    }

    public function setUserGateway($userGateway)
    {
        $this->userGateway = $userGateway;
    }
}