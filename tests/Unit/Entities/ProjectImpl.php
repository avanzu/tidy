<?php
/**
 * ProjectStub1.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\Entities;


use Tidy\Entities\Project;

class ProjectImpl extends Project
{

    /**
     * ProjectImpl constructor.
     */
    public function __construct($owner) {
        $this->owner = $owner;
    }
}