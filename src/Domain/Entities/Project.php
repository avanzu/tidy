<?php
/**
 * Project.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Entities;

use Tidy\Components\AccessControl\IClaimable;
use Tidy\Components\AccessControl\IClaimant;
use Tidy\Components\Events\IMessenger;
use Tidy\Components\Events\TMessenger;
use Tidy\Domain\BusinessRules\ProjectRules;
use Tidy\Domain\Events\Project\Renamed;
use Tidy\Domain\Events\Project\SetUp;
use Tidy\Domain\Requestors\Project\ICreateRequest;
use Tidy\Domain\Requestors\Project\IRenameRequest;

abstract class Project implements IClaimable, IMessenger
{
    use TMessenger;

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
        return ($project instanceof Project) ? $project->getId() === $this->getId() : false;
    }

    /**
     * @param ICreateRequest $request
     * @param ProjectRules   $rules
     *
     * @return $this
     */
    public function setUp(ICreateRequest $request, ProjectRules $rules)
    {

        $rules->verifySetUp($request, $this);

        $this->id          = coalesce($this->id, uuid());
        $this->name        = $request->name();
        $this->description = $request->description();
        $this->canonical   = $request->canonical();
        $this->path        = sprintf('/%s/%s', static::PREFIX, $this->canonical);

        $this->queueEvent(new SetUp($this->id));

        return $this;
    }

    /**
     * @param IRenameRequest $request
     * @param ProjectRules   $rules
     */
    public function rename(IRenameRequest $request, ProjectRules $rules)
    {
        $rules->verifyRename($request);
        $this->name        = $request->name();
        $this->description = coalesce($request->description(), $this->description);

        $this->queueEvent(new Renamed($this->id));

    }


}