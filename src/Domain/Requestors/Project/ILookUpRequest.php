<?php
/**
 * ILookUpRequest.php
 * Tidy
 * Date: 22.04.18
 */
namespace Tidy\Domain\Requestors\Project;

interface ILookUpRequest
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
    public function projectId();
}