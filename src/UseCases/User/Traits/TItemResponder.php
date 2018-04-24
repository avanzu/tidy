<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\User\Traits;

use Tidy\Domain\Responders\User\IResponseTransformer;
use Tidy\UseCases\User\DTO\ResponseTransformer;

trait TItemResponder
{
    /**
     * @var IResponseTransformer
     */
    protected $transformer;

    /**
     * @var \Tidy\Domain\Gateways\IUserGateway
     */
    protected $userGateway;

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