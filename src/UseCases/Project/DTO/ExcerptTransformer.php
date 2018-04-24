<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Domain\Entities\Project;
use Tidy\Domain\Responders\Project\IExcerpt;
use Tidy\Domain\Responders\Project\IExcerptTransformer;

class ExcerptTransformer implements IExcerptTransformer
{

    /**
     * @param Project $project
     *
     * @return IExcerpt
     */
    public function excerpt(Project $project)
    {
        $excerpt            = new ExcerptDTO();
        $excerpt->name      = $project->getName();
        $excerpt->canonical = $project->getCanonical();
        $excerpt->id        = $project->getId();

        return $excerpt;

    }
}