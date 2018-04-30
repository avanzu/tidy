<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Entities;

use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Domain\Requestors\Project\ICreateRequest;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\ProjectImpl;

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

        $project->setUp($request);

        assertThat($project->getName(), is(equalTo('Demo')));
        assertThat($project->getDescription(), is(equalTo('This is a demo.')));
        assertThat($project->getCanonical(), is(equalTo('demo-1')));

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
            $project->setUp($request);
            $this->fail('Failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(PreconditionFailed::class)));
            assertThat(count($exception->getErrors()), is(equalTo($expectedErrorCount)));
        }
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