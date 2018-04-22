<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation;

use Mockery\MockInterface;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\ITranslationCatalogueResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\UseCases\Translation\CreateCatalogue;
use Tidy\UseCases\Translation\DTO\CreateCatalogueRequestDTO;

class CreateCatalogueTest extends MockeryTestCase
{
    /**
     * @var MockInterface|ITranslationCatalogueResponseTransformer
     */
    protected $transformer;

    /**
     * @var ITranslationGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var CreateCatalogue
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new CreateCatalogue(
            mock(ITranslationGateway::class),
            mock(ITranslationCatalogueResponseTransformer::class)
        );

        assertThat($useCase, is(notNullValue()));
    }

    public function test_execute()
    {
        $request = CreateCatalogueRequestDTO::make();
        assertThat($request, is(notNullValue()));
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->transformer = mock(ITranslationCatalogueResponseTransformer::class);
        $this->gateway     = mock(ITranslationGateway::class);
        $this->useCase = new CreateCatalogue(
            $this->gateway,
            $this->transformer
        );
    }


}