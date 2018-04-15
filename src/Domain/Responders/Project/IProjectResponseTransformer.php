<?php
/**
 * IProjectResponseTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Responders\Project;

use Tidy\Domain\Entities\Project;

interface IProjectResponseTransformer
{
    public function transform(Project $project);
}