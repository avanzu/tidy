<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

use Tidy\Domain\Responders\Project\IExcerptTransformer;
use Tidy\Domain\Responders\Translation\ICatalogueResponseTransformer;
use Tidy\Domain\Responders\Translation\ITranslationResponseTransformer;

class NestedCatalogueResponseTransformer extends CatalogueResponseTransformer implements ICatalogueResponseTransformer
{
    public function __construct(
        IExcerptTransformer $projectTransformer = null,
        ITranslationResponseTransformer $itemTransformer = null
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