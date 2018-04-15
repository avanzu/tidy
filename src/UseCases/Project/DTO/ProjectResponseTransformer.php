<?php
/**
 * ProjectResponseTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project\DTO;


use Tidy\Entities\Project;

class ProjectResponseTransformer
{
    public function transform(Project $project)
    {
        $response              = new ProjectResponseDTO();
        $response->id          = $project->getId();
        $response->name        = $project->getName();
        $response->description = $project->getDescription();

        return $response;
    }
}