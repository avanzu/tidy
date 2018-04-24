<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Responders\Translation\ChangeResponder;
use Tidy\UseCases\Translation\Catalogue\DTO\RemoveTranslationRequestDTO;

class RemoveTranslation extends ChangeResponder
{

    public function execute(RemoveTranslationRequestDTO $request) {

        $catalogue   = $this->gateway->findCatalogue($request->catalogueId());
        $translation = $catalogue->find($request->token());

        $this->gateway->removeTranslation($translation);
        $catalogue->remove($translation);

        $result = ChangeSet::make(
            Change::remove($this->pathInCatalogue($catalogue, $translation))
        );

        return $this->transformer()->transform($result);
    }

    /**
     * @param $catalogue
     * @param $translation
     *
     * @return string
     */
    protected function pathInCatalogue(TranslationCatalogue $catalogue, Translation $translation)
    {
        return sprintf('%s/%s', $catalogue->getCanonical(), $translation->getId());
    }

}