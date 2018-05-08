<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Gateways;

use Mockery\MockInterface;
use Tidy\Components\Events\IDispatcher;
use Tidy\Domain\BusinessRules\TranslationRules;
use Tidy\Domain\Events\Translation\SetUp;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Gateways\TranslationGateway;
use Tidy\Domain\Repositories\ITranslationRepository;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\ProjectSilverTongue;
use Tidy\Tests\Unit\Fixtures\Gateways\TranslationGatewayImpl;
use Tidy\UseCases\Translation\Catalogue\DTO\CreateCatalogueRequestBuilder;

class TranslationGatewayTest extends MockeryTestCase
{

    /**
     * @var ITranslationRepository|MockInterface
     */
    private $repository;

    /**
     * @var IProjectGateway|MockInterface
     */
    private $projectGateway;

    /**
     * @var IDispatcher|MockInterface
     */
    private $dispatcher;

    /**
     * @var TranslationGateway
     */
    private $gateway;

    public function testSave()
    {
        $this->projectGateway->expects('find')->andReturn(new ProjectSilverTongue());
        $catalogue = $this->gateway->makeCatalogueForProject(ProjectSilverTongue::ID);
        $request   = (new CreateCatalogueRequestBuilder())
            ->withName('The test catalogue')
            ->withSourceLocale('de', 'DE')
            ->withTargetLocale('en', 'US')
            ->build()
        ;
        $rules = mock(TranslationRules::class);
        $rules->expects('verifySetUp');
        $catalogue->setUp($request, $rules);
        $this->dispatcher->expects('broadcast')->with(anInstanceOf(SetUp::class));
        $this->gateway->save($catalogue);

        $this->assertCount(0, $catalogue->events());

    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->repository     = mock(ITranslationRepository::class);
        $this->projectGateway = mock(IProjectGateway::class);
        $this->dispatcher     = mock(IDispatcher::class);
        $this->gateway        = new TranslationGatewayImpl(
            $this->repository,
            $this->projectGateway,
            $this->dispatcher
        );

    }
}