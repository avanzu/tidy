<?php
/**
 * IGetProjectRequest.php
 * Tidy
 * Date: 22.04.18
 */
namespace Tidy\Domain\Requestors\Project;

interface IGetProjectRequest
{
    /**
     * @param $id
     *
     * @return $this
     */
    public function withProjectId($id);

    /**
     * @return int
     */
    public function getProjectId();
}