<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Catalogue\DTO;

use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Responders\CollectionResponse;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponse;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponseTransformer;
use Tidy\Domain\Responders\Translation\Catalogue\ICollectionResponse;
use Tidy\Domain\Responders\Translation\Catalogue\ICollectionResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\UseCases\Translation\Catalogue\DTO\CollectionResponseTransformer;

class CollectionResponseTransformerTest extends MockeryTestCase
{
    public function test_instantiation()
    {
        $transformer = new CollectionResponseTransformer();
        assertThat($transformer, is(anInstanceOf(ICollectionResponseTransformer::class)));
    }

    public function test_swapItemTransformer()
    {
        $itemTransformer    = mock(ICatalogueResponseTransformer::class);
        $initialTransformer = mock(ICatalogueResponseTransformer::class);
        $transformer        = new CollectionResponseTransformer(
            $initialTransformer
        );
        $return             = $transformer->swapItemTransformer($itemTransformer);
        assertThat($return, is($initialTransformer));
        assertThat($transformer->swapItemTransformer($initialTransformer), is(sameInstance($itemTransformer)));
    }

    public function test_transform()
    {
        $collection  = new PagedCollection([new TranslationCatalogueEnglishToGerman()], 1, 1, 10);
        $transformer = new CollectionResponseTransformer();
        $result      = $transformer->transform($collection);
        assertThat($result, is(anInstanceOf(ICollectionResponse::class)));
        assertThat($result, is(anInstanceOf(CollectionResponse::class)));

        assertThat(count($result), is(equalTo(1)));
        assertThat(current($result->getItems()), is(anInstanceOf(ICatalogueResponse::class)));

        assertThat($result->currentPage(), is(equalTo(1)));
        assertThat($result->pagesTotal(), is(equalTo(1)));
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

    }
}