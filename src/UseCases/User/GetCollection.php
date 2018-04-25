<?php
/**
 * GetCatalogueCollection.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Requestors\ICollectionRequest;
use Tidy\Domain\Requestors\User\IGetCollectionRequest;
use Tidy\Domain\Responders\User\ICollectionResponse;
use Tidy\Domain\Responders\User\ICollectionResponseTransformer;
use Tidy\UseCases\User\DTO\CollectionResponseTransformer;

/**
 * Class GetCatalogueCollection
 */
class GetCollection
{
    /**
     * @var \Tidy\Domain\Gateways\IUserGateway
     */
    protected $gateway;

    /**
     * @var ICollectionResponseTransformer
     */
    private $transformer;

    /**
     * GetCatalogueCollection constructor.
     *
     * @param IUserGateway                   $gateway
     * @param ICollectionResponseTransformer $transformer
     */
    public function __construct(IUserGateway $gateway, ICollectionResponseTransformer $transformer = null)
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

        $response = $this->transformer()->transform($collection);

        return $response;
    }

    /**
     * @param IUserGateway $gateway
     */
    public function setUserGateway(IUserGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @param ICollectionResponseTransformer $transformer
     */
    public function setResponseTransformer(ICollectionResponseTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new CollectionResponseTransformer();
        }

        return $this->transformer;
    }


}