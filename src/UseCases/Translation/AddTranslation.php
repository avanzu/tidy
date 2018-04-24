<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Components\Exceptions\Duplicate;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Requestors\Translation\IAddTranslationRequest;
use Tidy\Domain\Responders\Translation\ChangeResponder;

class AddTranslation extends ChangeResponder
{


    public function execute(IAddTranslationRequest $request)
    {
        $catalogue = $this->lookUpCatalogue($request);

        $this->preserveUniqueness($request, $catalogue);

        $translation = $this->gateway->makeTranslation();

        $translation
            ->setSourceString($request->sourceString())
            ->setLocaleString($request->localeString())
            ->setMeaning($request->meaning())
            ->setNotes($request->notes())
            ->setState($request->state())
            ->setToken($request->token())
        ;

        $catalogue->addTranslation($translation);

        $this->gateway->save($catalogue);

        $result = ChangeSet::make();
        $result
            ->add(
                Change::add(
                    $translation->toArray(),
                    sprintf('%s/%s', $catalogue->getCanonical(), $translation->getId())
                )
            )
        ;

        return $this->transformer()->transform($result);

    }

    /**
     * @param IAddTranslationRequest $request
     *
     * @return null|\Tidy\Domain\Entities\TranslationCatalogue
     */
    protected function lookUpCatalogue(IAddTranslationRequest $request)
    {
        $catalogue = $this->gateway->findCatalogue($request->catalogueId());
        if (!$catalogue) {
            throw new NotFound(
                sprintf('Unable to find catalogue identified by "%d".', $request->catalogueId())
            );
        }

        return $catalogue;
    }

    /**
     * @param IAddTranslationRequest $request
     * @param                          $catalogue
     */
    protected function preserveUniqueness(IAddTranslationRequest $request, TranslationCatalogue $catalogue)
    {
        if ($match = $catalogue->find($request->token())) {
            throw new Duplicate(
                sprintf('Duplicate token "%s" in catalogue "%s".', $request->token, $catalogue->getName())
            );
        }
    }


}