<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation;

use Tidy\Domain\Responders\Project\IExcerptTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman as TestCatalogue;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueImpl;
use Tidy\UseCases\Project\DTO\ExcerptDTO;
use Tidy\UseCases\Translation\DTO\CatalogueResponseTransformer;
use Tidy\UseCases\Translation\DTO\TranslationResponseTransformer;

class CatalogueResponseTransformerTest extends MockeryTestCase
{

    /**
     * @var CatalogueResponseTransformer
     */
    protected $transformer;

    public function test_instantiation()
    {
        $excerpt     = mock(IExcerptTransformer::class);
        $transformer = new CatalogueResponseTransformer($excerpt);
        $old         = $transformer->swapExcerptTransformer(mock(IExcerptTransformer::class));

        assertThat($old, is(sameInstance($excerpt)));

        $transformer->useItemTransformer(mock(TranslationResponseTransformer::class));
    }


    public function test_transform()
    {
        $response = $this->transformer->transform(new TestCatalogue());
        assertThat($response->getName(), is(equalTo(TestCatalogue::NAME)));
        assertThat($response->getCanonical(), is(equalTo(TestCatalogue::CANONICAL)));
        assertThat($response->getSourceCulture(), is(equalTo(TestCatalogue::SOURCE_CULTURE)));
        assertThat($response->getSourceLanguage(), is(equalTo(TestCatalogue::SOURCE_LANG)));
        assertThat($response->getTargetLanguage(), is(equalTo(TestCatalogue::TARGET_LANG)));
        assertThat($response->getTargetCulture(), is(equalTo(TestCatalogue::TARGET_CULTURE)));
        assertThat($response->getProject(), is(anInstanceOf(ExcerptDTO::class)));

        assertThat(count($response), is(equalTo(0)));
    }


    public function test_transform_with_itemTransformer()
    {
        $this->transformer->useItemTransformer(new TranslationResponseTransformer());
        $response = $this->transformer->transform(new TestCatalogue());

        assertThat(count($response), is(equalTo(2)));
    }


    public function test_transform_empty_project()
    {
        $response = $this->transformer->transform(new TranslationCatalogueImpl());
        assertThat($response->getProject(), is(nullValue()));
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->transformer = new CatalogueResponseTransformer();
    }

}