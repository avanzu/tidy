<?php
/**
 * Project.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Entities;

use ArrayObject;
use Tidy\Components\AccessControl\IClaimable;
use Tidy\Components\AccessControl\IClaimant;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Domain\Collections\Projects;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Requestors\Project\ICreateRequest;
use Tidy\Domain\Requestors\Project\IRenameRequest;

abstract class Project implements IClaimable
{
    const PREFIX = 'projects';


    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $canonical;

    /**
     * @var IClaimant
     */
    protected $owner;

    /**
     * @var string
     */
    protected $path;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCanonical()
    {
        return $this->canonical;
    }


    public function path()
    {
        return $this->path;
    }

    /**
     * @param IClaimant $user
     */
    public function grantOwnershipTo(IClaimant $user)
    {
        $this->owner = $user;
    }

    /**
     * @return IClaimant
     */
    public function getOwner()
    {
        return $this->owner;
    }

    public function isIdentical($project)
    {
        return ($project instanceof  Project) ? $project->getId() === $this->getId() : false;
    }

    /**
     * @param ICreateRequest $request
     * @param Projects       $projects
     *
     * @return $this
     */
    public function setUp(ICreateRequest $request, Projects $projects)
    {

        $this->verifySetUp($request, $projects);

        $this->id          = uuid();
        $this->name        = $request->name();
        $this->description = $request->description();
        $this->canonical   = $request->canonical();
        $this->path        = sprintf('/%s/%s', static::PREFIX, $this->canonical);

        return $this;
    }

    /**
     * @param IRenameRequest $request
     */
    public function rename(IRenameRequest $request)
    {
        $this->verifyRename($request);
        $this->name        = $request->name();
        $this->description = $request->description();

    }

    private function verifySetUp(ICreateRequest $request, Projects $projects)
    {
        $errors = new ArrayObject();
        $errors = $this->verifyName($request->name(), $errors);
        $errors = $this->verifyCanonical($request, $projects, $errors);

        $this->failOnErrors($errors);
    }

    private function verifyRename(IRenameRequest $request)
    {
        $errors = new ArrayObject();
        $this->verifyName($request->name(), $errors);

        $this->failOnErrors($errors);
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
     * @param ICreateRequest $request
     * @param Projects       $projects
     * @param                $errors
     *
     * @return mixed
     */
    protected function verifyCanonical(ICreateRequest $request, Projects $projects, $errors)
    {
        if (strlen($request->canonical()) < 3) {
            $errors['canonical'] = sprintf(
                'Invalid canonical "%s". Canonical must contain at least 3 characters.',
                $request->canonical()
            );

            return $errors;
        }

        if ($match = $projects->findByCanonical($request->canonical())) {
            if (!$this->isIdentical($match)) {
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
     * @param $errors
     */
    private function failOnErrors($errors): void
    {
        if (0 < $errors->count()) {
            throw new PreconditionFailed($errors->getArrayCopy());
        }
    }

}