<?php
/**
 * UseCaseProject.php
 * Tidy
 * Date: 22.04.18
 */

namespace Tidy\UseCases\Project;

use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Responders\Project\IResponseTransformer;
use Tidy\UseCases\Project\DTO\ResponseTransformer;

abstract class UseCaseProject
{
    /**
     * @var IResponseTransformer
     */
    protected $transformer;

    /**
     * @var IProjectGateway
     */
    protected $gateway;

    /**
     * UseCaseProject constructor.
     *
     * @param IProjectGateway      $projectGateway
     * @param IResponseTransformer $transformer
     */
    public function __construct(IProjectGateway $projectGateway, IResponseTransformer $transformer = null)
    {
        $this->transformer = $transformer;
        $this->gateway     = $projectGateway;
    }

    protected function transformer()
    {
        if( ! $this->transformer) $this->transformer = new ResponseTransformer();
        return $this->transformer;
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