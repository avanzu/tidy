<?php
/**
 * ProjectResponseTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;


use Tidy\Domain\Entities\Project;
use Tidy\Domain\Responders\AccessControl\IOwnerExcerpt;
use Tidy\Domain\Responders\AccessControl\IOwnerExcerptTransformer;
use Tidy\Domain\Responders\Project\IProjectResponseTransformer;
use Tidy\UseCases\AccessControl\DTO\OwnerExcerptTransformer;

class ProjectResponseTransformer implements IProjectResponseTransformer
{
    /**
     * @var OwnerExcerptTransformer
     */
    private $ownerExcerptTransformer;


    /**
     * ProjectResponseTransformer constructor.
     *
     * @param IOwnerExcerptTransformer|null $ownerExcerptTransformer
     */
    public function __construct(IOwnerExcerptTransformer $ownerExcerptTransformer = null)
    {
        $this->ownerExcerptTransformer = $ownerExcerptTransformer;
    }

    public function transform(Project $project)
    {
        $response = new ProjectResponseDTO();

        $this->transformProject($project, $response);
        $this->assignOwner($project, $response);

        return $response;
    }

    /**
     * @return IOwnerExcerptTransformer|OwnerExcerptTransformer
     */
    private function getOwnerTransformer()
    {
        if (!$this->ownerExcerptTransformer) {
            $this->ownerExcerptTransformer = new OwnerExcerptTransformer();
        }

        return $this->ownerExcerptTransformer;
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
     * @return IOwnerExcerpt
     */
    private function transformOwner(Project $project)
    {
        return $this->getOwnerTransformer()->excerpt($project->getOwner());
    }
}