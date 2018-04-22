<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Message;

use Tidy\Domain\Gateways\IMessageGateway;
use Tidy\Domain\Responders\Message\IMessageResponseTransformer;

class CreateCatalogue
{
    /**
     * @var IMessageGateway
     */
    protected $gateway;

    /**
     * @var IMessageResponseTransformer
     */
    private $transformer;

    /**
     * CreateCatalogue constructor.
     *
     * @param IMessageGateway             $gateway
     * @param IMessageResponseTransformer $transformer
     */
    public function __construct(IMessageGateway $gateway, IMessageResponseTransformer $transformer)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }


}