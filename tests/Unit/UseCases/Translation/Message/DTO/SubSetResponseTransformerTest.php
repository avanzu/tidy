<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Message\DTO;

use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Responders\CollectionResponse;
use Tidy\Domain\Responders\Translation\Message\ISubSetResponse;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationTranslated;
use Tidy\Tests\Unit\Domain\Entities\TranslationUntranslated;
use Tidy\UseCases\Translation\Message\DTO\SubSetResponseTransformer;

class SubSetResponseTransformerTest extends MockeryTestCase
{


    public function test_instantiation()
    {
        $transformer = new SubSetResponseTransformer(mock(ITranslationResponseTransformer::class));
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
        assertThat($result, is(anInstanceOf(ISubSetResponse::class)));
        assertThat($result, is(anInstanceOf(CollectionResponse::class)));

        assertThat(count($result), is(2));
    }
}