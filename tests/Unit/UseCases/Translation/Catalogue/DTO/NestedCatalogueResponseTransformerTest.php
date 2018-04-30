<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Catalogue\DTO;

use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponse;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueEnglishToGerman;

class NestedCatalogueResponseTransformerTest extends MockeryTestCase
{

    public function test_instantiation()
    {
        $transformer = new \Tidy\UseCases\Translation\Catalogue\DTO\NestedCatalogueResponseTransformer();
        assertThat($transformer, is(notNullValue()));
    }

    public function test_transform()
    {
        $transformer = new \Tidy\UseCases\Translation\Catalogue\DTO\NestedCatalogueResponseTransformer();
        $result      = $transformer->transform(new TranslationCatalogueEnglishToGerman());

        assertThat($result, is(anInstanceOf(ICatalogueResponse::class)));

    }

}