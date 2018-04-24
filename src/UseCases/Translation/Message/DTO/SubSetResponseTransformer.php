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
use Tidy\Domain\Responders\Translation\Message\ISubSetResponseTransformer;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponseTransformer;

class SubSetResponseTransformer implements ISubSetResponseTransformer
{
    /**
     * @var \Tidy\Domain\Responders\Translation\Message\ITranslationResponseTransformer
     */
    protected $itemTransformer;

    /**
     * SubSetResponseTransformer constructor.
     *
     * @param \Tidy\Domain\Responders\Translation\Message\ITranslationResponseTransformer $itemTransformer
     */
    public function __construct(ITranslationResponseTransformer $itemTransformer = null)
    {
        $this->itemTransformer = $itemTransformer;
    }


    public function transform(IPagedCollection $collection)
    {
        $response = new SubSetResponseDTO();
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