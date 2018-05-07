<?php
/**
 * RenameTest Tidy
 * Date: 22.04.18
 */

namespace Tidy\Tests\Unit\UseCases\Project;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Domain\BusinessRules\ProjectRules;
use Tidy\Domain\Entities\Project;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Responders\Project\IResponse;
use Tidy\Domain\Responders\Project\IResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\ProjectSilverTongue;
use Tidy\UseCases\Project\DTO\RenameRequestBuilder;
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
        $useCase = new Rename(mock(IProjectGateway::class), mock(ProjectRules::class), mock(IResponseTransformer::class));
        assertThat($useCase, is(notNullValue()));
    }

    public function test_rename()
    {
        $expectedName        = ProjectSilverTongue::NAME.' Renamed';
        $expectedDescription = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $request = (new RenameRequestBuilder())
            ->withProjectId(ProjectSilverTongue::ID)
            ->renameTo($expectedName)
            ->describeAs($expectedDescription)
            ->build()
        ;

        assertThat($request, is(anInstanceOf(RenameRequestDTO::class)));

        $this->expectProjectLookUp(ProjectSilverTongue::ID, new ProjectSilverTongue());
        $this->expectSave($expectedName, $expectedDescription);

        $result = $this->useCase->execute($request);

        assertThat($result, is(anInstanceOf(IResponse::class)));
        assertThat($result->getId(), is(equalTo(ProjectSilverTongue::ID)));
    }

    public function test_rename_verifies()
    {
        $request = (new RenameRequestBuilder())->withProjectId(ProjectSilverTongue::ID)->renameTo('')->build();
        $this->expectProjectLookUp(ProjectSilverTongue::ID, new ProjectSilverTongue());
        try {
            $this->useCase->execute($request);
        } catch(\Exception $exception) {
            assertThat($exception, is(anInstanceOf(PreconditionFailed::class)));
        }
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(IProjectGateway::class);
        $rules = new ProjectRules($this->gateway);
        $this->useCase = new Rename($this->gateway, $rules);
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