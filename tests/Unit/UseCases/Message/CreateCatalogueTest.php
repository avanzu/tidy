<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Message;

use Tidy\Domain\Gateways\IMessageGateway;
use Tidy\Domain\Responders\Message\IMessageResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\UseCases\Message\CreateCatalogue;

class CreateCatalogueTest extends MockeryTestCase
{
    public function test_instantiation() {
        $useCase = new CreateCatalogue(mock(IMessageGateway::class), mock(IMessageResponseTransformer::class));
        assertThat($useCase, is(notNullValue()));
    }
}