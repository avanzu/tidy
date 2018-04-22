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
use Tidy\Domain\Requestors\User\IGetUserCollectionRequest;
use Tidy\Domain\Responders\User\IUserCollectionResponse;
use Tidy\Domain\Responders\User\IUserCollectionResponseTransformer;
use Tidy\UseCases\User\DTO\UserCollectionResponseTransformer;

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
     * @var IUserCollectionResponseTransformer
     */
    private $transformer;

    /**
     * @param IGetUserCollectionRequest $request
     *
     * @return IUserCollectionResponse
     */
    public function execute(IGetUserCollectionRequest $request)
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
        if( ! $this->transformer ) $this->transformer = new UserCollectionResponseTransformer();
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
     * @param IUserCollectionResponseTransformer $transformer
     */
    public function setResponseTransformer(IUserCollectionResponseTransformer $transformer)
    {
        $this->transformer = $transformer;
    }


}