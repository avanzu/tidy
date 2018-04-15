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
use Tidy\Responders\Project\IProjectResponse;
use Tidy\Responders\Project\IProjectResponseTransformer;

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
     * CreateProject constructor.
     *
     * @param IProjectGateway $projectGateway
     * @param IProjectResponseTransformer $transformer
     * @param ITextNormaliser $normaliser
     */
    public function __construct(
        IProjectGateway $projectGateway,
        IProjectResponseTransformer $transformer,
        ITextNormaliser $normaliser
    ) {
        $this->projectGateway = $projectGateway;
        $this->transformer    = $transformer;
        $this->normaliser     = $normaliser;
    }


    public function setResponseTransformer($transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param ICreateProjectRequest $request
     *
     * @return IProjectResponse
     */
    public function execute(ICreateProjectRequest $request)
    {

        $project   = $this->projectGateway->makeForOwner($request->getOwnerId());
        $canonical = $this->normaliser->transform($request->getName());
        $project
            ->setName($request->getName())
            ->setDescription($request->getDescription())
            ->setCanonical($canonical)
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