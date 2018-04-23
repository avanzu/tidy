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

class Rename extends UseCasePatch
{

    public function execute(IRenameRequest $request)
    {

        $project = $this->gateway->find($request->projectId());
        $project
            ->setName($request->name())
            ->setDescription($request->description())
        ;

        $this->gateway->save($project);

        $result = ChangeSet::make()
                            ->add(Change::test($request->projectId(), 'id'))
                           ->add(Change::replace($request->name(), 'name'))
                           ->add(Change::replace($request->description(), 'description'))
        ;

        return $this->transformer()->transform($result);
    }
}