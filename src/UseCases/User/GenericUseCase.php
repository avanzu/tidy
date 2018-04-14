<?php
/**
 * GenericUseCase.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User;


use Tidy\Gateways\IUserGateway;
use Tidy\Responders\User\IUserResponseTransformer;

abstract class GenericUseCase
{

    /**
     * @var IUserResponseTransformer
     */
    protected $responseTransformer;
    /**
     * @var IUserGateway
     */
    protected $userGateway;

    /**
     * GenericUseCase constructor.
     *
     * @param IUserGateway             $userGateway
     * @param IUserResponseTransformer $responseTransformer
     */
    public function __construct( IUserGateway $userGateway, IUserResponseTransformer $responseTransformer )
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