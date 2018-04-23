<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\DTO;

use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationTranslated;
use Tidy\UseCases\Translation\DTO\TranslationResponseDTO;
use Tidy\UseCases\Translation\DTO\TranslationResponseTransformer;

class TranslationResponseTransformerTest extends MockeryTestCase
{

    public function test_instantiation()
    {
        $transformer = new TranslationResponseTransformer();
        assertThat($transformer, is(notNullValue()));
    }

    public function test_transform()
    {
        $transformer = new TranslationResponseTransformer();
        $result = $transformer->transform(new TranslationTranslated());
        assertThat($result, is(anInstanceOf(TranslationResponseDTO::class)));

        assertThat($result->getId(), is(equalTo(TranslationTranslated::MSG_ID)));
        assertThat($result->getSourceString(), is(equalTo(TranslationTranslated::MSG_SOURCE)));
        assertThat($result->getLocaleString(), is(equalTo(TranslationTranslated::MSG_TARGET)));
        assertThat($result->getMeaning(), is(equalTo(TranslationTranslated::MSG_MEANING)));
        assertThat($result->getNotes(), is(equalTo(TranslationTranslated::MSG_NOTES)));
        assertThat($result->getState(), is(equalTo(TranslationTranslated::MSG_STATE)));
    }

}