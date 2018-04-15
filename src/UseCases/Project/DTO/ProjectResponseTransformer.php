<?php
/**
 * ProjectResponseTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;


use Tidy\Domain\Entities\Project;
use Tidy\Domain\Responders\Project\IProjectResponseTransformer;
use Tidy\Domain\Responders\User\IUserExcerpt;
use Tidy\UseCases\User\DTO\UserExcerptTransformer;

class ProjectResponseTransformer implements IProjectResponseTransformer
{
    /**
     * @var UserExcerptTransformer
     */
    private $userExcerptTransformer;


    /**
     * ProjectResponseTransformer constructor.
     *
     * @param UserExcerptTransformer $userExcerptTransformer
     */
    public function __construct(UserExcerptTransformer $userExcerptTransformer)
    {

        $this->userExcerptTransformer = $userExcerptTransformer;
    }

    public function transform(Project $project)
    {
        $response = new ProjectResponseDTO();

        $this->transformProject($project, $response);
        $this->assignOwner($project, $response);

        return $response;
    }

    /**
     * @param Project $project
     * @param         $response
     */
    private function assignOwner(Project $project, $response)
    {
        $response->owner = $this->transformOwner($project);
    }

    /**
     * @param Project $project
     * @param         $response
     */
    private function transformProject(Project $project, $response)
    {
        $response->id          = $project->getId();
        $response->name        = $project->getName();
        $response->description = $project->getDescription();
        $response->canonical   = $project->getCanonical();
    }

    /**
     * @param Project $project
     *
     * @return IUserExcerpt
     */
    private function transformOwner(Project $project)
    {
        return $this->userExcerptTransformer->excerpt($project->getOwner());
    }
}