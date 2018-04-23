<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\UseCases\Translation\DTO\TranslationResponseTransformer;

class CreateTranslation
{
    /**
     * @var ITranslationGateway
     */
    protected $gateway;

    /**
     * @var TranslationResponseTransformer
     */
    private $transformer;

    /**
     * CreateTranslation constructor.
     *
     * @param ITranslationGateway                 $gateway
     * @param TranslationResponseTransformer|null $transformer
     */
    public function __construct(ITranslationGateway $gateway, TranslationResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }

    public function swapTransformer(TranslationResponseTransformer $transformer)
    {
        $previous          = $this->transformer;
        $this->transformer = $transformer;

        return $previous;
    }

    /*
    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new TranslationResponseTransformer();
        }

        return $this->transformer;
    }
    */

}