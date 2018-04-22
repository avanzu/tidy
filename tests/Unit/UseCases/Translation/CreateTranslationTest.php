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
use Tidy\Tests\MockeryTestCase;
use Tidy\UseCases\Translation\CreateTranslation;

class CreateTranslationTest extends MockeryTestCase
{

    /**
     * @var CreateTranslation
     */
    protected $useCase;

    /**
     * @var ITranslationGateway|MockInterface
     */
    private   $gateway;

    public function test_instantiation()
    {
        $useCase = new CreateTranslation(mock(ITranslationGateway::class));
        assertThat($useCase, is(notNullValue()));
    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new CreateTranslation($this->gateway);
    }

}