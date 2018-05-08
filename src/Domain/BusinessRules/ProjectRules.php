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
use Tidy\Components\Validation\Violation;
use Tidy\Domain\Entities\Project;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Requestors\Project\ICreateRequest;
use Tidy\Domain\Requestors\Project\IRenameRequest;

class ProjectRules
{
    /**
     * @var IProjectGateway
     */
    protected $gateway;

    /**
     * ProjectRules constructor.
     *
     * @param IProjectGateway $gateway
     */
    public function __construct(IProjectGateway $gateway) { $this->gateway = $gateway; }

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
            $errors['canonical'] = new Violation(
                'Invalid canonical "{{ canonical }}". Canonical must contain at least 3 characters.',
                ['{{ canonical }}' => $request->canonical()]
            );

            return $errors;
        }

        if ($match = $this->gateway->findByCanonical($request->canonical())) {
            if (!$project->isIdentical($match)) {
                $errors['canonical'] = new Violation(
                    'Invalid canonical "{{ canonical }}". Already in use by "{{ catalogue }}".',
                    ['{{ canonical }}' => $request->canonical(), '{{ catalogue }}' => $match->getName()]
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
            $errors['name'] = new Violation(
                'Invalid name "{{ name }}". Name must contain at least 3 characters.',
                ['{{ name }}' => $value]
            );
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