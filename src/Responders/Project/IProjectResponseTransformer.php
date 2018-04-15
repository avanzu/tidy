<?php
/**
 * IProjectResponseTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Responders\Project;

use Tidy\Entities\Project;

interface IProjectResponseTransformer
{
    public function transform(Project $project);
}