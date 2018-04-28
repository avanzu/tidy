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
     * @return int
     */
    public function projectId();
}