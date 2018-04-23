<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\User;

use Tidy\Domain\Gateways\IUserGateway;
use Tidy\Domain\Responders\Audit\ChangeResponseTransformer;
use Tidy\Domain\Responders\Audit\IChangeResponseTransformer;

abstract class UseCasePatch
{
    /**
     * @var IChangeResponseTransformer
     */
    protected $transformer;

    /**
     * @var \Tidy\Domain\Gateways\IUserGateway
     */
    protected $userGateway;


    /**
     * UseCase constructor.
     *
     * @param IUserGateway               $userGateway
     * @param IChangeResponseTransformer $responseTransformer
     */
    public function __construct(IUserGateway $userGateway, IChangeResponseTransformer $responseTransformer = null)
    {
        $this->userGateway = $userGateway;
        $this->transformer = $responseTransformer;
    }

    public function setUserGateway($userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function setTransformer(IChangeResponseTransformer $transformer)
    {
        $this->transformer = $transformer;

    }

    /**
     * @return ChangeResponseTransformer|IChangeResponseTransformer
     */
    protected function transformer()
    {
        if( ! $this->transformer) $this->transformer = new ChangeResponseTransformer();
        return $this->transformer;
    }

}