<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Tests\Unit\Fixtures\Gateways;

use Tidy\Components\Collection\Boundary;
use Tidy\Components\Collection\IPagedCollection;
use Tidy\Components\DataAccess\Comparison;
use Tidy\Components\Events\IDispatcher;
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Entities\TranslationDomain;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Gateways\TranslationGateway;
use Tidy\Domain\Repositories\ITranslationRepository;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueImpl;

class TranslationGatewayImpl extends TranslationGateway
{

    /**
     * @var ITranslationRepository
     */
    protected $repository;

    /**
     * @var IProjectGateway
     */
    protected $projectGateway;

    public function __construct(
        ITranslationRepository $repository,
        IProjectGateway $projectGateway,
        IDispatcher $dispatcher
    ) {
        parent::__construct($dispatcher);
        $this->repository     = $repository;
        $this->projectGateway = $projectGateway;
    }


    protected function doSave(TranslationCatalogue $catalogue)
    {
    }

    /**
     * @param TranslationDomain $domain
     *
     * @return TranslationCatalogue|null
     */
    public function findByDomain(TranslationDomain $domain)
    {
        return $this->repository->findByDomain($domain);
    }

    /**
     * @param $catalogueId
     *
     * @return TranslationCatalogue|null
     */
    public function findCatalogue($catalogueId)
    {
        return $this->repository->findCatalogue($catalogueId);
    }

    /**
     * @param Boundary     $boundary
     * @param Comparison[] $criteria
     *
     * @return IPagedCollection
     */
    public function getCollection(Boundary $boundary, array $criteria = [])
    {
        return $this->repository->getCollection($boundary, $criteria);
    }

    /**
     * @param int          $catalogueId
     * @param Boundary     $boundary
     * @param Comparison[] $criteria
     *
     * @return mixed
     */
    public function getSubSet(int $catalogueId, Boundary $boundary, array $criteria = [])
    {
        return $this->repository->getSubSet($catalogueId, $boundary, $criteria);
    }

    /**
     * @param $projectId
     *
     * @return TranslationCatalogue
     */
    public function makeCatalogueForProject($projectId)
    {
        $catalogue = new TranslationCatalogueImpl();
        $catalogue->setProject($this->projectGateway->find($projectId));

        return $catalogue;
    }

    /**
     * @return Translation
     */
    public function makeTranslation()
    {
        // TODO: Implement makeTranslation() method.
        throw new \BadMethodCallException(__FUNCTION__." is not Implemented.");
    }

    /**
     * @param Translation $translation
     *
     * @return bool
     */
    public function removeTranslation($translation)
    {
        // TODO: Implement removeTranslation() method.
        throw new \BadMethodCallException(__FUNCTION__." is not Implemented.");
    }

    /**
     * @param       int    $catalogueId
     * @param Comparison[] $criteria
     *
     * @return mixed
     */
    public function subSetTotal($catalogueId, array $criteria = [])
    {
        return $this->repository->subSetTotal($catalogueId, $criteria);
    }

    /**
     * @param Comparison[] $criteria
     *
     * @return int
     */
    public function total(array $criteria = [])
    {
        return $this->repository->total($criteria);
    }
}