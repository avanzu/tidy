<?php
/**
 * RenameTest Tidy
 * Date: 22.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project;

use Mockery\MockInterface;
use Tidy\Components\Audit\Change;
use Tidy\Domain\Entities\Project;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Responders\Audit\ChangeResponseTransformer;
use Tidy\Domain\Responders\Audit\IChangeResponse;
use Tidy\Domain\Responders\Audit\IChangeResponseTransformer;
use Tidy\Domain\Responders\Project\ChangeResponder;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\ProjectSilverTongue;
use Tidy\UseCases\Project\DTO\RenameRequestDTO;
use Tidy\UseCases\Project\Rename;

class RenameTest extends MockeryTestCase
{
    /**
     * @var IProjectGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var Rename
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new Rename(mock(IProjectGateway::class), mock(IChangeResponseTransformer::class));

        assertThat($useCase, is(notNullValue()));
        assertThat($useCase, is(anInstanceOf(ChangeResponder::class)));
    }

    public function test_rename()
    {
        $request = RenameRequestDTO::make();
        assertThat($request, is(anInstanceOf(RenameRequestDTO::class)));
        $expectedName        = ProjectSilverTongue::NAME.' Renamed';
        $expectedDescription = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $request
            ->withProjectId(ProjectSilverTongue::ID)
            ->renameTo($expectedName)
            ->describeAs($expectedDescription)
        ;

        $this->expectProjectLookUp(ProjectSilverTongue::ID, new ProjectSilverTongue());
        $this->expectSave($expectedName, $expectedDescription);

        $result = $this->useCase->execute($request);

        $expected = [
            [
                'op'    => Change::OP_REPLACE,
                'value' => $expectedName,
                'path'  => 'name',
            ],
            [
                'op'    => Change::OP_REPLACE,
                'value' => $expectedDescription,
                'path'  => 'description',
            ],
        ];
        assertThat($result, is(anInstanceOf(IChangeResponse::class)));
        assertThat($result->changes(), is(equalTo($expected)));
    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(IProjectGateway::class);
        $this->useCase = new Rename($this->gateway, new ChangeResponseTransformer());
    }

    protected function expectProjectLookUp($projectId, $returnValue)
    {
        $this->gateway
            ->expects('find')
            ->with($projectId)
            ->andReturns($returnValue)
        ;
    }

    /**
     * @param $expectedName
     * @param $expectedDescription
     */
    protected function expectSave($expectedName, $expectedDescription): void
    {
        $this->gateway->expects('save')->with(
            argumentThat(
                function (Project $project) use ($expectedName, $expectedDescription) {
                    assertThat($project->getName(), is(equalTo($expectedName)));
                    assertThat($project->getDescription(), is(equalTo($expectedDescription)));

                    return true;
                }
            )
        )
        ;
    }
}