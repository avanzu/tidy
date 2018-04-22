<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\Domain\Gateways\ITranslationGateway;

class CreateTranslation
{
    /**
     * @var ITranslationGateway
     */
    protected $gateway;

    /**
     * CreateTranslation constructor.
     *
     * @param ITranslationGateway $gateway
     */
    public function __construct(ITranslationGateway $gateway) {
        $this->gateway = $gateway;
    }


}