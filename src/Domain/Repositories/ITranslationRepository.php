<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Domain\Repositories;

use Tidy\Components\Collection\Boundary;
use Tidy\Components\Collection\ICollection;
use Tidy\Components\Collection\IPagedCollection;
use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Entities\TranslationDomain;

interface ITranslationRepository
{

    /**
     * @param TranslationDomain $domain
     *
     * @return TranslationCatalogue|null
     */
    public function findByDomain(TranslationDomain $domain);

    /**
     * @param $catalogueId
     *
     * @return TranslationCatalogue|null
     */
    public function findCatalogue($catalogueId);

    /**
     * @param $boundary
     * @param $criteria
     *
     * @return IPagedCollection
     */
    public function getCollection(Boundary $boundary, array $criteria = []);

    /**
     * @param int          $catalogueId
     * @param Boundary     $boundary
     * @param Comparison[] $criteria
     *
     *
     * @return ICollection
     */
    public function getSubSet(int $catalogueId, Boundary $boundary, array $criteria = []);

    /**
     * @param       int    $catalogueId
     * @param Comparison[] $criteria
     *
     * @return int
     */
    public function subSetTotal($catalogueId, array $criteria = []);

    /**
     * @param Comparison[] $criteria
     *
     * @return int
     */
    public function total(array $criteria = []);

}