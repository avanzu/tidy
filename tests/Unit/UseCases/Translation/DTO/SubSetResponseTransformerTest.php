<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\DTO;

use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Responders\CollectionResponse;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationTranslated;
use Tidy\Tests\Unit\Domain\Entities\TranslationUntranslated;
use Tidy\UseCases\Translation\DTO\SubSetResponseDTO;
use Tidy\UseCases\Translation\DTO\SubSetResponseTransformer;
use Tidy\UseCases\Translation\DTO\TranslationResponseTransformer;

class SubSetResponseTransformerTest extends MockeryTestCase
{


    public function test_instantiation()
    {
        $transformer = new SubSetResponseTransformer(mock(TranslationResponseTransformer::class));
        assertThat($transformer, is(notNullValue()));

    }


    public function test_transform()
    {
        $collection  = new PagedCollection(
            [new TranslationTranslated(), new TranslationUntranslated()],
            2,
            1,
            15
        );
        $transformer = new SubSetResponseTransformer();
        $result      = $transformer->transform($collection);
        assertThat($result, is(anInstanceOf(SubSetResponseDTO::class)));
        assertThat($result, is(anInstanceOf(CollectionResponse::class)));

        assertThat(count($result), is( 2));
    }
}