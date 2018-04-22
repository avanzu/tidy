<?php
/**
 * This file is part of the Tidy Project.
 *
 * IRenameProjectRequest.php Created by avanzu on 22.04.18 with PhpStorm.
 *
 */
namespace Tidy\Domain\Requestors\Project;

interface IRenameProjectRequest
{
    /**
     * @param $id
     *
     * @return IRenameProjectRequest
     */
    public function withProjectId($id);

    /**
     * @param $name
     *
     * @return IRenameProjectRequest
     */
    public function renameTo($name);

    /**
     * @param $description
     *
     * @return IRenameProjectRequest
     */
    public function describeAs($description);

    public function projectId();

    public function name();

    public function description();
}