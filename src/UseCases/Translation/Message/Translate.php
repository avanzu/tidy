<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation\Message;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\BusinessRules\TranslationRules;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\Message\ITranslateRequest;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponse;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponseTransformer;
use Tidy\UseCases\Translation\Message\Traits\TItemResponder;

class Translate
{

    use TItemResponder;

    /**
     * @var TranslationRules
     */
    private $rules;

    /**
     * CreateCatalogue constructor.
     *
     * @param ITranslationGateway             $gateway
     * @param TranslationRules                $rules
     * @param ITranslationResponseTransformer $transformer
     */
    public function __construct(ITranslationGateway $gateway, TranslationRules $rules, ITranslationResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
        $this->rules = $rules;
    }

    /**
     * @param ITranslateRequest $request
     *
     * @return ITranslationResponse
     */
    public function execute(ITranslateRequest $request)
    {

        $catalogue   = $this->lookUpCatalogue($request);
        $translation = $catalogue->translate($request, $this->rules);

        $this->gateway->save($catalogue);

        return $this->transformer()->transform($translation);
    }


    /**
     * @param ITranslateRequest $request
     *
     * @return null|TranslationCatalogue
     */
    protected function lookUpCatalogue(ITranslateRequest $request)
    {
        $catalogue = $this->gateway->findCatalogue($request->catalogueId());
        if (!$catalogue) {
            throw new NotFound(sprintf('Unable to find catalogue identified by "%d".', $request->catalogueId()));
        }

        return $catalogue;
    }


}