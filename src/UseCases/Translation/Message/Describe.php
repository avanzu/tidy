<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 05.05.18
 *
 */

namespace Tidy\UseCases\Translation\Message;

use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\BusinessRules\TranslationRules;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponse;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponseTransformer;
use Tidy\UseCases\Translation\Message\DTO\DescribeRequestDTO;
use Tidy\UseCases\Translation\Message\Traits\TItemResponder;

class Describe
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
     * @param ITranslationResponseTransformer $transformer
     */
    public function __construct(ITranslationGateway $gateway, TranslationRules $rules, ITranslationResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
        $this->rules = $rules;
    }

    /**
     * @param DescribeRequestDTO $request
     *
     * @return ITranslationResponse
     */
    public function execute(DescribeRequestDTO $request)
    {
        $catalogue = $this->gateway->findCatalogue($request->catalogueId());
        if (!$catalogue) {
            throw new NotFound(sprintf('Unable to find catalogue identified by "%d".', $request->catalogueId()));
        }
        $translation = $catalogue->describe($request, $this->rules);
        $this->gateway->save($catalogue);

        return $this->transformer()->transform($translation);
    }


}