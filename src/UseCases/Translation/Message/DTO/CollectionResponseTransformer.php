<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\Message\DTO;

use Tidy\Components\Collection\IPagedCollection;
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Responders\Translation\Message\ICollectionResponseTransformer;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponseTransformer;

class CollectionResponseTransformer implements ICollectionResponseTransformer
{
    /**
     * @var ITranslationResponseTransformer
     */
    protected $itemTransformer;

    /**
     * CollectionResponseTransformer constructor.
     *
     * @param ITranslationResponseTransformer $itemTransformer
     */
    public function __construct(ITranslationResponseTransformer $itemTransformer = null)
    {
        $this->itemTransformer = $itemTransformer;
    }


    public function transform(IPagedCollection $collection)
    {
        $response = new CollectionResponseDTO();
        $response->pickBoundaries($collection);
        $response->items = $collection->map(
            function (Translation $translation) { return $this->itemTransformer()->transform($translation); }
        );

        return $response;
    }

    /**
     * @return ITranslationResponseTransformer
     */
    protected function itemTransformer()
    {
        if (!$this->itemTransformer) {
            $this->itemTransformer = new TranslationResponseTransformer();
        }

        return $this->itemTransformer;
    }

}