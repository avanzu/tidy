<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Domain\Responders\Translation\Message;

use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\UseCases\Translation\Message\DTO\TranslationResponseTransformer;

abstract class ItemResponder
{

    /**
     * @var ITranslationResponseTransformer
     */
    protected $transformer;

    /**
     * @var ITranslationGateway
     */
    protected $gateway;

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

    /**
     * @return ITranslationResponseTransformer
     */
    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new TranslationResponseTransformer();
        }

        return $this->transformer;
    }
}