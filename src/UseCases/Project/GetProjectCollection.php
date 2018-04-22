<?php
/**
 * GetProjectCollection.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\UseCases\Project;

use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\UseCases\Project\DTO\GetProjectCollectionRequestDTO;
use Tidy\UseCases\Project\DTO\ProjectCollectionResponseTransformer;

class GetProjectCollection
{
    /**
     * @var IProjectGateway
     */
    protected $gateway;

    /**
     * @var ProjectCollectionResponseTransformer
     */
    protected $transformer;

    /**
     * GetProjectCollection constructor.
     *
     * @param IProjectGateway                      $gateway
     * @param ProjectCollectionResponseTransformer $transformer
     */
    public function __construct(IProjectGateway $gateway, ProjectCollectionResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer ?: new ProjectCollectionResponseTransformer();
    }

    public function execute(GetProjectCollectionRequestDTO $request)
    {

        $items      = $this->gateway->fetchCollection(
            $request->getPage(),
            $request->getPageSize(),
            $request->getCriteria()
        );

        $collection = new PagedCollection(
            $items,
            $this->gateway->total($request->getCriteria()),
            $request->getPage(),
            $request->getPageSize()
        );

        return $this->transformer->transform($collection);
    }


}