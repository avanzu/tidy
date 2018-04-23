<?php
/**
 * UseCase.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\UseCases\User;

use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\UseCases\User\DTO\ResponseTransformer;

abstract class UseCase
{

    /**
     * @var IResponseTransformer
     */
    protected $transformer;

    /**
     * @var \Tidy\Domain\Gateways\IUserGateway
     */
    protected $userGateway;


    /**
     * UseCase constructor.
     *
     * @param IUserGateway         $userGateway
     * @param IResponseTransformer $responseTransformer
     */
    public function __construct(IUserGateway $userGateway, IResponseTransformer $responseTransformer = null)
    {
        $this->userGateway = $userGateway;
        $this->transformer = $responseTransformer;
    }

    public function setUserGateway($userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;

    }

    /**
     * @return IResponseTransformer
     */
    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new ResponseTransformer();
        }

        return $this->transformer;
    }
}