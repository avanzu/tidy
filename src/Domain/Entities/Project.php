<?php
/**
 * Project.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Entities;

use Tidy\Components\AccessControl\IClaimable;
use Tidy\Components\AccessControl\IClaimant;

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

    /**
     * @param string $canonical
     *
     * @return $this
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;

        return $this;
    }

    public function path()
    {
        return sprintf('/%s/%s', static::PREFIX, $this->canonical);
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

}