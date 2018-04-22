<?php
/**
 * IResponseTransformer.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Responders\Project;

use Tidy\Domain\Entities\Project;

interface IResponseTransformer
{
    public function transform(Project $project);
}