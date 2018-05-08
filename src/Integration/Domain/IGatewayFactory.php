<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Integration\Domain;

use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Gateways\IUserGateway;

interface IGatewayFactory
{
    /**
     * @return IUserGateway
     */
    public function makeUserGateway();

    /**
     * @return IProjectGateway
     */
    public function makeProjectGateway();

    /**
     * @return ITranslationGateway
     */
    public function makeTranslationGateway();
}