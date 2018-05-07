<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Entities;

use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Domain\Collections\Projects;
use Tidy\Domain\Events\Project\Renamed;
use Tidy\Domain\Events\Project\SetUp;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Requestors\Project\ICreateRequest;
use Tidy\Domain\Requestors\Project\IRenameRequest;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\ProjectImpl;
use Tidy\Tests\Unit\Fixtures\Entities\ProjectSilverTongue;

class ProjectTest extends MockeryTestCase
{

    public function test_SetUp()
    {

        $project = new ProjectImpl();
        $request = new class implements ICreateRequest
        {

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

            public function canonical()
            {
                return 'demo-1';
            }
        };

        $gateway  = mock(IProjectGateway::class);
        $gateway->expects('findByCanonical')->with('demo-1')->andReturn(null);

        $project->setUp($request, new Projects($gateway));

        assertThat($project->getName(), is(equalTo('Demo')));
        assertThat($project->getDescription(), is(equalTo('This is a demo.')));
        assertThat($project->getCanonical(), is(equalTo('demo-1')));

        $this->assertCount(1, $project->events());
        $event = $project->events()->dequeue();
        $this->assertInstanceOf(SetUp::class, $event);
        $this->assertEquals($project->getId(), $event->id());

    }

    /**
     * @dataProvider provideSetupData
     *
     * @param $name
     * @param $description
     * @param $canonical
     * @param $expectedErrorCount
     */
    public function test_verifies_setUp($name, $description, $canonical, $expectedErrorCount)
    {
        $project = new ProjectImpl();
        $request = mock(ICreateRequest::class);
        $request->allows('name')->andReturn($name);
        $request->allows('description')->andReturn($description);
        $request->allows('canonical')->andReturn($canonical);

        try {
            $project->setUp($request, new Projects(mock(IProjectGateway::class)));
            $this->fail('Failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(PreconditionFailed::class)));
            assertThat(count($exception->getErrors()), is(equalTo($expectedErrorCount)));
        }
    }

    public function test_setup_verifies_unique_canonical()
    {
        $project = new ProjectImpl();
        $request = mock(ICreateRequest::class);
        $request->allows('name')->andReturn(ProjectSilverTongue::NAME);
        $request->allows('description')->andReturn(ProjectSilverTongue::DESCRIPTION);
        $request->allows('canonical')->andReturn(ProjectSilverTongue::CANONICAL);
        $gateway = mock(IProjectGateway::class);
        $gateway->expects('findByCanonical')->with(ProjectSilverTongue::CANONICAL)->andReturn(new ProjectSilverTongue());
        try {
            $project->setUp($request, new Projects($gateway));
            $this->fail('Failed to fail.');
        } catch (PreconditionFailed $exception) {
            assertThat($exception, is(anInstanceOf(PreconditionFailed::class)));
            $this->assertStringMatchesFormat('Invalid canonical "%s". Already in use by "%s".', current($exception->getErrors()));
        }
    }

    public function testRename()
    {
        $request = mock(IRenameRequest::class);
        $expectedName    = 'Lorem ipsum Project';
        $request->shouldReceive('name')->andReturn($expectedName);
        $request->shouldReceive('description')->andReturn(null);
        $project = new ProjectSilverTongue();
        $project->rename($request);
        $this->assertEquals($expectedName, $project->getName());
        $event = $project->events()->dequeue();
        $this->assertInstanceOf(Renamed::class, $event);

    }

    public function provideSetupData()
    {
        return [
            'without name' => [
                'name'        => null,
                'description' => null,
                'canonical'   => null,
                'errorCount'  => 2,
            ],
        ];
    }

}