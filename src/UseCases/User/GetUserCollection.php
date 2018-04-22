<?php
/**
 * GetUserCollection.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Components\Collection\Boundary;
use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Requestors\User\IGetCollectionRequest;
use Tidy\Domain\Responders\User\ICollectionResponse;
use Tidy\Domain\Responders\User\ICollectionResponseTransformer;
use Tidy\UseCases\User\DTO\CollectionResponseTransformer;

/**
 * Class GetUserCollection
 */
class GetUserCollection
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
     * @param IGetCollectionRequest $request
     *
     * @return ICollectionResponse
     */
    public function execute(IGetCollectionRequest $request)
    {
        $boundary   = $request->boundary();
        $items      = $this->gateway->fetchCollection($boundary, $request->criteria());
        $total      = $this->gateway->total($request->criteria());
        $collection = new PagedCollection($items,$total,$boundary->page,$boundary->pageSize);

        $response = $this->transformer()->transform($collection);

        return $response;
    }

    protected function transformer()
    {
        if( ! $this->transformer ) $this->transformer = new CollectionResponseTransformer();
        return $this->transformer;
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


}