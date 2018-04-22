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
use Tidy\Tests\Unit\Domain\Entities\ProjectImpl;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman as Testee;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueImpl;
use Tidy\UseCases\Project\DTO\ExcerptDTO;
use Tidy\UseCases\Translation\DTO\CatalogueResponseTransformer;

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
        $old = $transformer->swapExcerptTransformer(mock(IExcerptTransformer::class));
        assertThat($old, is(sameInstance($excerpt)));

        // assertThat($transformer, is(notNullValue()));

    }

    public function test_transform()
    {
        $response = $this->transformer->transform(new Testee());
        assertThat($response->getName(), is(equalTo(Testee::NAME)));
        assertThat($response->getCanonical(), is(equalTo(Testee::CANONICAL)));
        assertThat($response->getSourceCulture(), is(equalTo(Testee::SOURCE_CULTURE)));
        assertThat($response->getSourceLanguage(), is(equalTo(Testee::SOURCE_LANG)));
        assertThat($response->getTargetLanguage(), is(equalTo(Testee::TARGET_LANG)));
        assertThat($response->getTargetCulture(), is(equalTo(Testee::TARGET_CULTURE)));
        assertThat($response->getProject(), is(anInstanceOf(ExcerptDTO::class)));
    }

    public function test_transform_empty_project()
    {
        $response =  $this->transformer->transform(new TranslationCatalogueImpl());
        assertThat($response->getProject(), is(nullValue()));
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->transformer = new CatalogueResponseTransformer();
    }

}