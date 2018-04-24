<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\UseCases\Translation\DTO\TranslateRequestDTO;

class Translate extends PatchUseCase
{


    public function execute(TranslateRequestDTO $request)
    {

        $catalogue   = $this->lookUpCatalogue($request);
        $translation = $this->lookUpTranslation($request, $catalogue);
        $changes     = ChangeSet::make()
                                ->add($this->replaceLocaleString($request, $translation))
                                ->add($this->replaceState($request, $translation))
        ;

        if (count($changes)) {
            $this->gateway->save($catalogue);
        }

        return $this->transformer()->transform($changes);
    }


    /**
     * @param TranslateRequestDTO $request
     * @param Translation         $translation
     *
     * @return null|Change
     */
    protected function replaceLocaleString(TranslateRequestDTO $request, Translation $translation)
    {
        if (!$request->localeString()) {
            return null;
        }

        $translation->setLocaleString($request->localeString());

        return Change::replace($request->localeString(), $this->pathTo($translation, 'localeString'));
    }

    /**
     * @param TranslateRequestDTO $request
     * @param Translation         $translation
     *
     * @return null|Change
     */
    protected function replaceState(TranslateRequestDTO $request, Translation $translation)
    {
        if (!$request->state()) {
            return null;
        }
        $translation->setState($request->state());

        return Change::replace($request->state(), $this->pathTo($translation, 'state'));
    }

    /**
     * @param Translation $translation
     * @param             $attribute
     *
     * @return string
     */
    protected function pathTo(Translation $translation, $attribute)
    {
        return sprintf('%s/%s', $translation->getId(), $attribute);
    }

    /**
     * @param TranslateRequestDTO $request
     *
     * @return null|\Tidy\Domain\Entities\TranslationCatalogue
     */
    protected function lookUpCatalogue(TranslateRequestDTO $request)
    {
        $catalogue = $this->gateway->findCatalogue($request->catalogueId());
        if (!$catalogue) {
            throw new NotFound(sprintf('Unable to find catalogue identified by "%d".', $request->catalogueId()));
        }

        return $catalogue;
    }

    /**
     * @param TranslateRequestDTO $request
     * @param                     $catalogue
     *
     * @return mixed
     */
    protected function lookUpTranslation(TranslateRequestDTO $request, TranslationCatalogue $catalogue)
    {
        $translation = $catalogue->find($request->token());
        if( ! $translation )
            throw new NotFound(
                sprintf('Unable to find translation identified by "%s" in catalogue "%s".', $request->token(), $catalogue->getName())
            );
        return $translation;
    }

}