<?php
/**
 * GetUserCollection.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Gateways\UserGatewayInterface;
use Tidy\Tests\Unit\Entities\UserStub1;
use Tidy\Tests\Unit\Entities\UserStub2;
use Tidy\UseCases\User\DTO\GetUserCollectionRequestDTO;
use Tidy\UseCases\User\DTO\UserCollectionResponseDTO;
use Tidy\UseCases\User\DTO\UserCollectionResponseTransformer;
use Tidy\UseCases\User\DTO\UserResponseDTO;

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

    public function execute(GetUserCollectionRequestDTO $request)
    {
        $users    = $this->gateway->fetchCollection($request->getPage(), $request->getPageSize());
        $response = $this->transformer->transform($users,$request->getPage(),$request->getPageSize());

        return $response;
    }

    public function setUserGateway(UserGatewayInterface $gateway) {
        $this->gateway = $gateway;
    }

    public function setCollectionResponseTransformer(UserCollectionResponseTransformer $transformer) {
        $this->transformer = $transformer;
    }


}