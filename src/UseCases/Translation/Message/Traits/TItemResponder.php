<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\Translation\Message\Traits;

use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponseTransformer;
use Tidy\UseCases\Translation\Message\DTO\TranslationResponseTransformer;

trait TItemResponder
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