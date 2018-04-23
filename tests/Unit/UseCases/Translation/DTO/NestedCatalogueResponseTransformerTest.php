<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\DTO;

use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\UseCases\Translation\DTO\CatalogueResponseDTO;
use Tidy\UseCases\Translation\DTO\NestedCatalogueResponseTransformer;

class NestedCatalogueResponseTransformerTest extends MockeryTestCase
{

    public function test_instantiation()
    {
        $transformer = new NestedCatalogueResponseTransformer();
        assertThat($transformer, is(notNullValue()));
    }

    public function test_transform()
    {
        $transformer = new NestedCatalogueResponseTransformer();
        $result = $transformer->transform(new TranslationCatalogueEnglishToGerman());

        assertThat($result, is(anInstanceOf(CatalogueResponseDTO::class)));

    }

}