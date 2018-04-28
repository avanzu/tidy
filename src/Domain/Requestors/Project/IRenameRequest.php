<?php
/**
 * This file is part of the Tidy Project.
 *
 * IRenameRequest.php Created by avanzu on 22.04.18 with PhpStorm.
 *
 */
namespace Tidy\Domain\Requestors\Project;

interface IRenameRequest
{


    public function projectId();

    public function name();

    public function description();
}