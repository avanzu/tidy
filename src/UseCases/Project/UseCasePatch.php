<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Project;

use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Responders\Audit\ChangeResponseTransformer;
use Tidy\Domain\Responders\Audit\IChangeResponseTransformer;

class UseCasePatch
{

    /**
     * @var IChangeResponseTransformer
     */
    protected $transformer;

    /**
     * @var IProjectGateway
     */
    protected $gateway;

    /**
     * UseCaseProject constructor.
     *
     * @param IProjectGateway            $projectGateway
     * @param IChangeResponseTransformer $transformer
     */
    public function __construct(IProjectGateway $projectGateway, IChangeResponseTransformer $transformer = null)
    {
        $this->transformer = $transformer;
        $this->gateway     = $projectGateway;
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