<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Domain\Responders\Project;

use Tidy\Domain\Entities\Project;

interface IExcerptTransformer
{
    public function excerpt(Project $project);
}