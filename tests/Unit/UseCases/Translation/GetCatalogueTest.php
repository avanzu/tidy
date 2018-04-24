<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation;

use Mockery\MockInterface;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\UseCases\Translation\GetCatalogue;
use Tidy\UseCases\Translation\UseCase;

class GetCatalogueTest extends MockeryTestCase
{

    /**
     * @var ITranslationGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var GetCatalogue
     */
    protected $useCase;

    public function test_instantiation()
    {

        $useCase = new GetCatalogue(mock(ITranslationGateway::class));
        assertThat($useCase, is(anInstanceOf(UseCase::class)));

    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new GetCatalogue($this->gateway);
    }

}