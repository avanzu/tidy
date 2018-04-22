<?php
/**
 * RenameProject.php
 * Tidy
 * Date: 22.04.18
 */

namespace Tidy\UseCases\Project;

use Tidy\Domain\Requestors\Project\IRenameProjectRequest;
use Tidy\UseCases\Project\DTO\RenameProjectRequestDTO;

class RenameProject extends UseCaseProject
{

    public function execute(IRenameProjectRequest $request)
    {

        $project = $this->gateway->find($request->projectId());
        $project
            ->setName($request->name())
            ->setDescription($request->description())
        ;
        $this->gateway->save($project);

        return $this->transformer()->transform($project);
    }
}