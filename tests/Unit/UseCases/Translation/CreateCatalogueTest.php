<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation;

use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\ITranslationResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\UseCases\Translation\CreateCatalogue;

class CreateCatalogueTest extends MockeryTestCase
{
    public function test_instantiation() {
        $useCase = new CreateCatalogue(mock(ITranslationGateway::class), mock(ITranslationResponseTransformer::class));
        assertThat($useCase, is(notNullValue()));
    }
}