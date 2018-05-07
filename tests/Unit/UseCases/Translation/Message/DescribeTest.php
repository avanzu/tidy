<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 05.05.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Message;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Domain\BusinessRules\TranslationRules;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponse;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueEnglishToGerman as Catalogue;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationUntranslated;
use Tidy\UseCases\Translation\Message\Describe;
use Tidy\UseCases\Translation\Message\DTO\DescribeRequestBuilder;
use Tidy\UseCases\Translation\Message\DTO\DescribeRequestDTO;

class DescribeTest extends MockeryTestCase
{
    /**
     * @var MockInterface|ITranslationGateway
     */
    protected $gateway;

    /**
     * @var Describe
     */
    protected $useCase;

    public function testInstantiation()
    {
        $useCase = new Describe(mock(ITranslationGateway::class), mock(TranslationRules::class));
        $this->assertNotNull($useCase);
    }

    public function testExecute()
    {
        $request = (new DescribeRequestBuilder())
            ->withCatalogueId(Catalogue::ID)
            ->withToken(TranslationUntranslated::MSG_ID)
            ->describeAs('The source')
            ->explainWith('The meaning')
            ->annotateWith('These are some notes')
            ->build()
        ;
        $this->assertInstanceOf(DescribeRequestDTO::class, $request);

        $catalogue = new Catalogue();
        $this->expectfindCatalogueOnGateway($catalogue, Catalogue::ID);
        $this->expectSaveOnGateway($catalogue);

        $result = $this->useCase->execute($request);

        $this->assertInstanceOf(ITranslationResponse::class, $result);
        $this->assertEquals(TranslationUntranslated::MSG_ID, $result->getToken());
        $this->assertEquals('The source', $result->getSourceString());
    }

    public function testExecuteUsesCoalesceForOptionalValues()
    {
        $request = (new DescribeRequestBuilder())
            ->withCatalogueId(Catalogue::ID)
            ->withToken(TranslationUntranslated::MSG_ID)
            ->describeAs('The source')
            ->build()
        ;

        $catalogue = new Catalogue();
        $this->expectfindCatalogueOnGateway($catalogue, Catalogue::ID);
        $this->expectSaveOnGateway($catalogue);

        $result = $this->useCase->execute($request);
        $this->assertEquals(TranslationUntranslated::MSG_MEANING, $result->getMeaning());
        $this->assertEquals(TranslationUntranslated::MSG_NOTES, $result->getNotes());

    }

    public function testExecuteThrowsNotFound()
    {
        $request = (new DescribeRequestBuilder())
            ->withCatalogueId(999)
            ->withToken('undefined_token')
            ->build()
        ;

        $this->expectfindCatalogueOnGateway(null, 999);

        try {
            $this->useCase->execute($request);
            $this->fail('Failed to fail.');
        } catch (NotFound $notFound) {
            $this->assertStringMatchesFormat('Unable to find catalogue identified by "%d".', $notFound->getMessage());
        }
    }

    public function testExecuteValidatesToken()
    {
        $request = (new DescribeRequestBuilder())
            ->withCatalogueId(Catalogue::ID)
            ->withToken('undefined_token')
            ->build()
        ;

        $this->expectfindCatalogueOnGateway(new Catalogue(), Catalogue::ID);

        try {
            $this->useCase->execute($request);
            $this->fail('Failed to fail.');
        } catch (PreconditionFailed $notFound) {
            $this->assertStringMatchesFormat(
                'Unable to find translation identified by "%s" in catalogue "%s".',
                $notFound->atIndex('token')
            );
        }
    }

    public function testExecuteValidatesCatalogue()
    {
        $request = (new DescribeRequestBuilder())
            ->withCatalogueId(999)
            ->withToken('undefined_token')
            ->build()
        ;

        $this->expectfindCatalogueOnGateway(new Catalogue(), 999);

        try {
            $this->useCase->execute($request);
            $this->fail('Failed to fail.');
        } catch (PreconditionFailed $notFound) {
            $this->assertStringMatchesFormat(
                'Wrong catalogue. Request addresses catalogue #%d. This is catalogue #%d.',
                $notFound->atIndex('catalogue')
            );
        }
    }


    /**
     * @param $catalogue
     * @param $catalogueId
     */
    protected function expectfindCatalogueOnGateway($catalogue, $catalogueId): void
    {
        $this->gateway
            ->expects('findCatalogue')
            ->with($catalogueId)
            ->andReturns($catalogue)
        ;
    }

    /**
     * @param $catalogue
     */
    protected function expectSaveOnGateway($catalogue): void
    {
        $this->gateway->expects('save')->with($catalogue);
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new Describe($this->gateway, new TranslationRules($this->gateway));

    }

}