<?php
/**
 * Rename.php
 * Tidy
 * Date: 22.04.18
 */

namespace Tidy\UseCases\Project;

use Tidy\Domain\Requestors\Project\IRenameRequest;
use Tidy\UseCases\Project\DTO\RenameRequestDTO;

class Rename extends UseCaseProject
{

    public function execute(IRenameRequest $request)
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