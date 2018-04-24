<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\Message;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Requestors\Translation\Message\ITranslateRequest;
use Tidy\Domain\Responders\Translation\ChangeResponder;

class Translate extends ChangeResponder
{


    public function execute(ITranslateRequest $request)
    {

        $catalogue   = $this->lookUpCatalogue($request);
        $translation = $this->lookUpTranslation($request, $catalogue);
        $changes     = ChangeSet::make(
            $this->replaceLocaleString($request, $translation),
            $this->replaceState($request, $translation)
        );

        if (count($changes)) {
            $this->gateway->save($catalogue);
        }

        return $this->transformer()->transform($changes);
    }


    /**
     * @param \Tidy\Domain\Requestors\Translation\Message\ITranslateRequest $request
     * @param Translation                                                   $translation
     *
     * @return null|Change
     */
    protected function replaceLocaleString(ITranslateRequest $request, Translation $translation)
    {
        if (!$request->localeString()) {
            return null;
        }

        $translation->setLocaleString($request->localeString());

        return Change::replace($request->localeString(), $this->pathTo($translation, 'localeString'));
    }

    /**
     * @param \Tidy\Domain\Requestors\Translation\Message\ITranslateRequest $request
     * @param Translation                                                   $translation
     *
     * @return null|Change
     */
    protected function replaceState(ITranslateRequest $request, Translation $translation)
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
     * @param \Tidy\Domain\Requestors\Translation\Message\ITranslateRequest $request
     *
     * @return null|\Tidy\Domain\Entities\TranslationCatalogue
     */
    protected function lookUpCatalogue(ITranslateRequest $request)
    {
        $catalogue = $this->gateway->findCatalogue($request->catalogueId());
        if (!$catalogue) {
            throw new NotFound(sprintf('Unable to find catalogue identified by "%d".', $request->catalogueId()));
        }

        return $catalogue;
    }

    /**
     * @param \Tidy\Domain\Requestors\Translation\Message\ITranslateRequest $request
     * @param                                                               $catalogue
     *
     * @return mixed
     */
    protected function lookUpTranslation(ITranslateRequest $request, TranslationCatalogue $catalogue)
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