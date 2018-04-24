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
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Responders\Translation\ChangeResponder;
use Tidy\UseCases\Translation\Catalogue\DTO\RemoveTranslationRequestDTO;

class RemoveTranslation extends ChangeResponder
{

    public function execute(RemoveTranslationRequestDTO $request) {

        $catalogue   = $this->lookUpCatalogue($request);
        $translation = $this->lookUpTranslation($request, $catalogue);

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

    /**
     * @param RemoveTranslationRequestDTO $request
     *
     * @return null|\Tidy\Domain\Entities\TranslationCatalogue
     */
    protected function lookUpCatalogue(RemoveTranslationRequestDTO $request)
    {
        $catalogue = $this->gateway->findCatalogue($request->catalogueId());
        if (!$catalogue) {
            throw new NotFound(sprintf('Unable to find catalogue identified by "%d".', $request->catalogueId()));
        }

        return $catalogue;
    }

    /**
     * @param RemoveTranslationRequestDTO $request
     * @param TranslationCatalogue        $catalogue
     *
     * @return mixed
     */
    protected function lookUpTranslation(RemoveTranslationRequestDTO $request, TranslationCatalogue $catalogue)
    {
        $translation = $catalogue->find($request->token());
        if (!$translation) {
            throw new NotFound(
                sprintf(
                    'Unable to find translation identified by "%s" in catalogue "%s".',
                    $request->token(),
                    $catalogue->getName()
                )
            );
        }

        return $translation;
    }

}