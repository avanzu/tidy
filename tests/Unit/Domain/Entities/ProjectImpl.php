<?php
/**
 * ProjectStub1.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\Domain\Entities;


use Tidy\Domain\Entities\Project;

class ProjectImpl extends Project
{

    /**
     * ProjectImpl constructor.
     */
    public function __construct($owner) {
        $this->owner = $owner;
    }
}