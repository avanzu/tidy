<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Entities;

use Tidy\Domain\Requestors\Project\ICreateRequest;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\ProjectImpl;

class ProjectTest extends MockeryTestCase
{

    public function test_SetUp(){

        $project = new ProjectImpl();
        $request = new class implements ICreateRequest {

            public function name()
            {
                return 'Demo';
            }

            public function description()
            {
                return 'This is a demo.';
            }

            public function ownerId()
            {
                return 99;
            }

            public function canonical() {
                return 'demo-1';
            }

            public function assignCanonical($canonical)
            {
            }
        };


        $project->setUp($request);

        assertThat($project->getName(), is(equalTo('Demo')));
        assertThat($project->getDescription(), is(equalTo('This is a demo.')));
        assertThat($project->getCanonical(), is(equalTo('demo-1')));

    }

}