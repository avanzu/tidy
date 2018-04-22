<?php
/**
 * GetProjectCollection.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\UseCases\Project;

use Tidy\Components\Collection\Boundary;
use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Requestors\Project\IGetProjectCollectionRequest;
use Tidy\Domain\Responders\Project\IProjectCollectionResponseTransformer;
use Tidy\UseCases\Project\DTO\ProjectCollectionResponseTransformer;

class GetProjectCollection
{
    /**
     * @var IProjectGateway
     */
    protected $gateway;

    /**
     * @var IProjectCollectionResponseTransformer
     */
    protected $transformer;

    /**
     * GetProjectCollection constructor.
     *
     * @param IProjectGateway                       $gateway
     * @param IProjectCollectionResponseTransformer $transformer
     */
    public function __construct(IProjectGateway $gateway, IProjectCollectionResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer ?: new ProjectCollectionResponseTransformer();
    }

    public function execute(IGetProjectCollectionRequest $request)
    {

        $boundary   = $request->getBoundary();
        $items      = $this->gateway->fetchCollection($boundary, $request->getCriteria());
        $total      = $this->gateway->total($request->getCriteria());
        $collection = new PagedCollection($items, $total, $boundary->page, $boundary->pageSize);

        return $this->transformer->transform($collection);
    }


}