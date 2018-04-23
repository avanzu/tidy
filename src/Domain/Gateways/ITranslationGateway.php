<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Domain\Gateways;

use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Entities\TranslationCatalogue;

interface ITranslationGateway
{

    /**
     * @param $projectId
     *
     * @return TranslationCatalogue
     */
    public function makeCatalogueForProject($projectId);

    /**
     * @return Translation
     */
    public function makeTranslation();

    /**
     * @param $catalogueId
     *
     * @return TranslationCatalogue|null
     */
    public function findCatalogue($catalogueId);

    /**
     * @param $catalogue
     *
     * @return mixed
     */
    public function save($catalogue);
}