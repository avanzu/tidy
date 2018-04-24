<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\Project\Traits;

use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Responders\Project\IResponseTransformer;
use Tidy\UseCases\Project\DTO\ResponseTransformer;

trait TItemResponder
{

    /**
     * @var IResponseTransformer
     */
    protected $transformer;

    /**
     * @var IProjectGateway
     */
    protected $gateway;


    public function setResponseTransformer($transformer)
    {
        $this->transformer = $transformer;
    }

    public function setProjectGateway($gateway)
    {
        $this->gateway = $gateway;
    }

    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new ResponseTransformer();
        }

        return $this->transformer;
    }
}