<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Audit\ChangeResponseTransformer;
use Tidy\Domain\Responders\Audit\IChangeResponseTransformer;

abstract class PatchUseCase
{

    /**
     * @var IChangeResponseTransformer
     */
    protected $transformer;

    /**
     * @var ITranslationGateway
     */
    protected $gateway;

    /**
     * CreateCatalogue constructor.
     *
     * @param ITranslationGateway        $gateway
     * @param IChangeResponseTransformer $transformer
     */
    public function __construct(ITranslationGateway $gateway, IChangeResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }

    public function swapTransformer(IChangeResponseTransformer $transformer)
    {
        $previous          = $this->transformer;
        $this->transformer = $transformer;

        return $previous;
    }

    /**
     * @return IChangeResponseTransformer
     */
    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new ChangeResponseTransformer();
        }

        return $this->transformer;
    }
}