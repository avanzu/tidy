<?php
/**
 * GetUserCollection.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Gateways\UserGatewayInterface;
use Tidy\UseCases\User\DTO\GetUserCollectionRequestDTO;
use Tidy\UseCases\User\DTO\UserCollectionResponseTransformer;

/**
 * Class GetUserCollection
 */
class GetUserCollection
{
    /**
     * @var UserGatewayInterface
     */
    protected $gateway;

    /**
     * @var UserCollectionResponseTransformer
     */
    private $transformer;

    /**
     * @param GetUserCollectionRequestDTO $request
     *
     * @return DTO\UserCollectionResponseDTO
     */
    public function execute(GetUserCollectionRequestDTO $request)
    {
        $users      = $this->gateway->fetchCollection($request->getPage(), $request->getPageSize());
        $totalItems = $this->gateway->getTotal();
        $response   = $this->transformer->transform($users, $request->getPage(), $request->getPageSize(), $totalItems);

        return $response;
    }

    /**
     * @param UserGatewayInterface $gateway
     */
    public function setUserGateway(UserGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @param UserCollectionResponseTransformer $transformer
     */
    public function setCollectionResponseTransformer(UserCollectionResponseTransformer $transformer)
    {
        $this->transformer = $transformer;
    }


}