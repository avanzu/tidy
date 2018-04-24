<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\Message;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\Message\ITranslateRequest;
use Tidy\Domain\Responders\Translation\Message\ItemResponder;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponseTransformer;
use Tidy\UseCases\Translation\Message\Traits\TItemResponder;

class Translate
{

    use TItemResponder;

    /**
     * CreateCatalogue constructor.
     *
     * @param ITranslationGateway             $gateway
     * @param ITranslationResponseTransformer $transformer
     */
    public function __construct(ITranslationGateway $gateway, ITranslationResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }

    public function execute(ITranslateRequest $request)
    {

        $catalogue   = $this->lookUpCatalogue($request);
        $translation = $this->lookUpTranslation($request, $catalogue);
        $this->replaceLocaleString($request, $translation);
        $this->replaceState($request, $translation);

        $this->gateway->save($catalogue);

        return $this->transformer()->transform($translation);
    }


    /**
     * @param \Tidy\Domain\Requestors\Translation\Message\ITranslateRequest $request
     * @param Translation                                                   $translation
     *
     */
    protected function replaceLocaleString(ITranslateRequest $request, Translation $translation)
    {
        if ($request->localeString()) {
            $translation->setLocaleString($request->localeString());
        }

    }

    /**
     * @param \Tidy\Domain\Requestors\Translation\Message\ITranslateRequest $request
     * @param Translation                                                   $translation
     *
     */
    protected function replaceState(ITranslateRequest $request, Translation $translation)
    {
        if ($request->state()) {
            $translation->setState($request->state());
        }

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