<?php
/**
 * UseCaseUser.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\UseCases\User\DTO\ResponseTransformer;

abstract class UseCaseUser
{

    /**
     * @var IResponseTransformer
     */
    protected $responseTransformer;

    /**
     * @var \Tidy\Domain\Gateways\IUserGateway
     */
    protected $userGateway;


    /**
     * UseCaseUser constructor.
     *
     * @param IUserGateway         $userGateway
     * @param IResponseTransformer $responseTransformer
     */
    public function __construct(IUserGateway $userGateway, IResponseTransformer $responseTransformer = null)
    {
        $this->userGateway         = $userGateway;
        $this->responseTransformer = $responseTransformer;
    }

    protected function transformer() {
        if( ! $this->responseTransformer ) $this->responseTransformer = $this->makeDefaultTransformer();

        return $this->responseTransformer;
    }

    protected function makeDefaultTransformer() {
        return new ResponseTransformer();
    }

    public function setUserGateway($userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function setResponseTransformer($responseTransformer)
    {
        $this->responseTransformer = $responseTransformer;

    }
}