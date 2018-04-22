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
    /**
     * @param $id
     *
     * @return IRenameRequest
     */
    public function withProjectId($id);

    /**
     * @param $name
     *
     * @return IRenameRequest
     */
    public function renameTo($name);

    /**
     * @param $description
     *
     * @return IRenameRequest
     */
    public function describeAs($description);

    public function projectId();

    public function name();

    public function description();
}