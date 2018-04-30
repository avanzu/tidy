<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 30.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Collections;

use Mockery\MockInterface;
use Tidy\Domain\Collections\Projects;
use Tidy\Domain\Entities\Project;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\ProjectSilverTongue;

class ProjectsTest extends MockeryTestCase
{

    /**
     * @var IProjectGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var Projects
     */
    protected $projects;

    public function test_instantiation()
    {
        $projects = new Projects(mock(IProjectGateway::class));
        assertThat($projects, is(notNullValue()));
    }

    public function test_findByCanonical()
    {
        $this->gateway->expects('findByCanonical')->with(ProjectSilverTongue::CANONICAL)->andReturn(
            new ProjectSilverTongue()
        )
        ;
        $result = $this->projects->findByCanonical(ProjectSilverTongue::CANONICAL);
        assertThat($result, is(anInstanceOf(Project::class)));
        assertThat($result->getId(), is(equalTo(ProjectSilverTongue::ID)));
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(IProjectGateway::class);
        $this->projects = new Projects($this->gateway);
    }
}