<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Domain\Gateways;

use Tidy\Domain\Entities\TranslationCatalogue;

interface ITranslationGateway
{

    /**
     * @return TranslationCatalogue
     */
    public function makeCatalogue();

    /**
     * @param $catalogue
     *
     * @return mixed
     */
    public function save($catalogue);
}