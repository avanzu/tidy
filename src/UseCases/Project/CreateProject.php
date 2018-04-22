<?php
/**
 * CreateProject.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project;


use Tidy\Components\Normalisation\ITextNormaliser;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Requestors\Project\ICreateProjectRequest;
use Tidy\Domain\Responders\Project\IProjectResponse;
use Tidy\Domain\Responders\Project\IProjectResponseTransformer;

class CreateProject extends UseCaseProject
{

    /**
     * @var ITextNormaliser
     */
    protected $normaliser;


    /**
     * CreateProject constructor.
     *
     * @param IProjectGateway             $projectGateway
     * @param ITextNormaliser             $normaliser
     * @param IProjectResponseTransformer $transformer
     */
    public function __construct(
        IProjectGateway $projectGateway,
        ITextNormaliser $normaliser,
        IProjectResponseTransformer $transformer = null
    ) {
        parent::__construct($projectGateway, $transformer);
        $this->normaliser     = $normaliser;
    }

    /**
     * @param ICreateProjectRequest $request
     *
     * @return IProjectResponse
     */
    public function execute(ICreateProjectRequest $request)
    {

        $project   = $this->gateway->makeForOwner($request->ownerId());
        $canonical = $this->normaliser->transform($request->name());
        $project
            ->setName($request->name())
            ->setDescription($request->description())
            ->setCanonical($canonical)
        ;

        $this->gateway->save($project);

        return $this->transformer()->transform($project);
    }

    public function setNormaliser($normaliser)
    {
        $this->normaliser = $normaliser;
    }

}