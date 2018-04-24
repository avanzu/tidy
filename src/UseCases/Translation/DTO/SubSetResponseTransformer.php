<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

use Tidy\Components\Collection\IPagedCollection;
use Tidy\Domain\Entities\Translation;

class SubSetResponseTransformer
{
    /**
     * @var TranslationResponseTransformer
     */
    protected $itemTransformer;

    /**
     * SubSetResponseTransformer constructor.
     *
     * @param TranslationResponseTransformer $itemTransformer
     */
    public function __construct(TranslationResponseTransformer $itemTransformer = null)
    {
        $this->itemTransformer = $itemTransformer;
    }


    public function transform(IPagedCollection $collection)
    {
        $response = new SubSetResponseDTO();
        $response->pickBoundaries($collection);
        $response->items = $collection->map(function(Translation $translation){ return $this->itemTransformer()->transform($translation); });

        return $response;
    }

    /**
     * @return TranslationResponseTransformer
     */
    protected function itemTransformer() {
        if( ! $this->itemTransformer ) $this->itemTransformer  = new TranslationResponseTransformer();
        return $this->itemTransformer;
    }

}