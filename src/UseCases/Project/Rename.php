<?php
/**
 * Rename.php
 * Tidy
 * Date: 22.04.18
 */

namespace Tidy\UseCases\Project;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Domain\Requestors\Project\IRenameRequest;
use Tidy\Domain\Responders\Project\ChangeResponder;

class Rename extends ChangeResponder
{

    public function execute(IRenameRequest $request)
    {

        $project = $this->gateway->find($request->projectId());
        $project
            ->setName($request->name())
            ->setDescription($request->description())
        ;

        $this->gateway->save($project);

        $result = ChangeSet::make(
            Change::replace($request->name(), 'name'),
            Change::replace($request->description(), 'description')
        )
        ;

        return $this->transformer()->transform($result);
    }
}