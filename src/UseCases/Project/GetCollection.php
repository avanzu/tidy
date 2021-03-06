<?php
/**
 * GetCatalogueCollection.php
 * Tidy
 * Date: 19.04.18
 */

namespace Tidy\UseCases\Project;

use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Requestors\ICollectionRequest;
use Tidy\Domain\Responders\Project\ICollectionResponse;
use Tidy\Domain\Responders\Project\ICollectionResponseTransformer;
use Tidy\UseCases\Project\DTO\CollectionResponseTransformer;

class GetCollection
{
    /**
     * @var IProjectGateway
     */
    protected $gateway;

    /**
     * @var ICollectionResponseTransformer
     */
    protected $transformer;

    /**
     * GetCatalogueCollection constructor.
     *
     * @param IProjectGateway                $gateway
     * @param ICollectionResponseTransformer $transformer
     */
    public function __construct(IProjectGateway $gateway, ICollectionResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }

    /**
     * @param ICollectionRequest $request
     *
     * @return ICollectionResponse
     */
    public function execute(ICollectionRequest $request)
    {

        $boundary   = $request->boundary();
        $items      = $this->gateway->fetchCollection($boundary, $request->criteria());
        $total      = $this->gateway->total($request->criteria());
        $collection = new PagedCollection($items, $total, $boundary->page, $boundary->pageSize);

        return $this->transformer()->transform($collection);
    }

    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new CollectionResponseTransformer();
        }

        return $this->transformer;

    }


}