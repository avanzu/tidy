<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

use Tidy\Domain\Responders\Project\IExcerptTransformer;

class NestedCatalogueResponseTransformer extends CatalogueResponseTransformer
{
    public function __construct(
        IExcerptTransformer $projectTransformer = null,
        TranslationResponseTransformer $itemTransformer = null
    ) {
        parent::__construct($projectTransformer);

        $this->itemTransformer = $itemTransformer;
    }


    protected function itemTransformer()
    {
        if (!$this->itemTransformer) {
            $this->itemTransformer = new TranslationResponseTransformer();
        }

        return $this->itemTransformer;
    }


}