<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 30.04.18
 *
 */

namespace Tidy\Domain\Collections;

use Tidy\Domain\Entities\TranslationDomain;
use Tidy\Domain\Gateways\ITranslationGateway;

class TranslationCatalogues
{
    /**
     * @var ITranslationGateway
     */
    protected $gateway;

    /**
     * TranslationCatalogues constructor.
     *
     * @param ITranslationGateway $gateway
     */
    public function __construct(ITranslationGateway $gateway) { $this->gateway = $gateway; }

    public function findByDomain(TranslationDomain $domain) {
        return $this->gateway->findByDomain($domain);
    }

}