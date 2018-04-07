<?php
/**
 * GetUserCollection.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


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
        $users      = $this->gateway->fetchCollection($request->getPage(), $request->getPageSize());
        $totalItems = $this->gateway->getTotal();
        $response   = $this->transformer->transform($users, $request->getPage(), $request->getPageSize(), $totalItems);

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
    public function setCollectionResponseTransformer(IUserCollectionResponseTransformer $transformer)
    {
        $this->transformer = $transformer;
    }


}