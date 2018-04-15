<?php
/**
 * GetUserCollection.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Components\Collection\PagedCollection;
use Tidy\Gateways\IUserGateway;
use Tidy\Requestors\User\IGetUserCollectionRequest;
use Tidy\Responders\User\IUserCollectionResponse;
use Tidy\Responders\User\IUserCollectionResponseTransformer;

/**
 * Class GetUserCollection
 */
class GetUserCollection
{
    /**
     * @var IUserGateway
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

        $collection = new PagedCollection(
            $this->gateway->fetchCollection($request->getPage(), $request->getPageSize()),
            $this->gateway->getTotal(),
            $request->getPage(),
            $request->getPageSize()
        );

        $response   = $this->transformer->transform($collection);

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
     * @param IUserCollectionResponseTransformer $transformer
     */
    public function setResponseTransformer(IUserCollectionResponseTransformer $transformer)
    {
        $this->transformer = $transformer;
    }


}