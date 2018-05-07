<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 07.05.18
 *
 */

namespace Tidy\Domain\BusinessRules;

use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Components\Validation\ErrorList;
use Tidy\Domain\Collections\Projects;
use Tidy\Domain\Entities\Project;
use Tidy\Domain\Requestors\Project\ICreateRequest;
use Tidy\Domain\Requestors\Project\IRenameRequest;

class ProjectRules
{
    /**
     * @var Projects
     */
    protected $projects;

    /**
     * ProjectRules constructor.
     *
     * @param Projects $projects
     */
    public function __construct(Projects $projects) { $this->projects = $projects; }

    public function verifySetUp(ICreateRequest $request, Project $project)
    {
        $errors = new ErrorList();
        $errors = $this->verifyName($request->name(), $errors);
        $errors = $this->verifyCanonical($request, $project, $errors);

        $this->failOnErrors($errors);
    }

    public function verifyRename(IRenameRequest $request)
    {
        $errors = new ErrorList();
        $this->verifyName($request->name(), $errors);

        $this->failOnErrors($errors);
    }

    /**
     * @param ICreateRequest $request
     * @param Project        $project
     * @param                $errors
     *
     * @return mixed
     */
    protected function verifyCanonical(ICreateRequest $request, Project $project, $errors)
    {
        if (strlen($request->canonical()) < 3) {
            $errors['canonical'] = sprintf(
                'Invalid canonical "%s". Canonical must contain at least 3 characters.',
                $request->canonical()
            );

            return $errors;
        }

        if ($match = $this->projects->findByCanonical($request->canonical())) {
            if (!$project->isIdentical($match)) {
                $errors['canonical'] = sprintf(
                    'Invalid canonical "%s". Already in use by "%s".',
                    $request->canonical(),
                    $match->getName()
                );
            }
        }

        return $errors;
    }

    /**
     * @param                $value
     * @param                $errors
     *
     * @return mixed
     */
    private function verifyName($value, $errors)
    {
        if (strlen($value) < 3) {
            $errors['name'] = sprintf('Invalid name "%s". Name must contain at least 3 characters.', $value);
        }

        return $errors;
    }

    /**
     * @param $errors
     */
    private function failOnErrors(ErrorList $errors)
    {
        if (0 < $errors->count()) {
            throw new PreconditionFailed($errors->getArrayCopy());
        }
    }
}