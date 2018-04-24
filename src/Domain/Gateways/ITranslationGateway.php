<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Domain\Gateways;

use Tidy\Components\Collection\Boundary;
use Tidy\Components\DataAccess\Comparison;
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

    /**
     * @param Boundary     $boundary
     * @param Comparison[] $criteria
     *
     * @return mixed
     */
    public function getCollection(Boundary $boundary, array $criteria = []);

    /**
     * @param Comparison[] $criteria
     *
     * @return int
     */
    public function total(array $criteria = []);

    /**
     * @param int          $catalogueId
     * @param Boundary     $boundary
     * @param Comparison[] $criteria
     *
     * @return mixed
     */
    public function getSubSet(int $catalogueId, Boundary $boundary, array $criteria = []);

    /**
     * @param       int    $catalogueId
     * @param Comparison[] $criteria
     *
     * @return mixed
     */
    public function subSetTotal($catalogueId, array $criteria = []);

    /**
     * @param Translation $translation
     *
     * @return bool
     */
    public function removeTranslation($translation);
}