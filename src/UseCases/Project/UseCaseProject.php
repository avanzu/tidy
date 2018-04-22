<?php
/**
 * UseCaseProject.php
 * Tidy
 * Date: 22.04.18
 */

namespace Tidy\UseCases\Project;

use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Responders\Project\IProjectResponseTransformer;

abstract class UseCaseProject
{
    /**
     * @var IProjectResponseTransformer
     */
    protected $transformer;

    /**
     * @var IProjectGateway
     */
    protected $gateway;

    /**
     * UseCaseProject constructor.
     *
     * @param IProjectGateway             $projectGateway
     * @param IProjectResponseTransformer $transformer
     */
    public function __construct(IProjectGateway $projectGateway, IProjectResponseTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->gateway     = $projectGateway;
    }

    public function setResponseTransformer($transformer)
    {
        $this->transformer = $transformer;
    }

    public function setProjectGateway($gateway)
    {
        $this->gateway = $gateway;
    }


}