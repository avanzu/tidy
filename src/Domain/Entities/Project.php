<?php
/**
 * Project.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Entities;

use Tidy\Components\AccessControl\IClaimable;
use Tidy\Components\AccessControl\IClaimant;
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
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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

    /**
     * @param ICreateRequest $request
     *
     * @return $this
     */
    public function setUp(ICreateRequest $request)
    {
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
        $this->name        = $request->name();
        $this->description = $request->description();

    }
}