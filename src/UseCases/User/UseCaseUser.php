<?php
/**
 * UseCaseUser.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\User\IUserResponseTransformer;

abstract class UseCaseUser
{

    /**
     * @var IUserResponseTransformer
     */
    protected $responseTransformer;
    /**
     * @var \Tidy\Domain\Gateways\IUserGateway
     */
    protected $userGateway;

    /**
     * UseCaseUser constructor.
     *
     * @param IUserGateway             $userGateway
     * @param IUserResponseTransformer $responseTransformer
     */
    public function __construct(IUserGateway $userGateway, IUserResponseTransformer $responseTransformer)
    {
        $this->responseTransformer = $responseTransformer;
        $this->userGateway         = $userGateway;
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