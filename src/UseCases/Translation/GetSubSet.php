<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\IGetSubSetRequest;
use Tidy\Domain\Responders\Translation\ISubSetResponseTransformer;
use Tidy\UseCases\Translation\DTO\SubSetResponseTransformer;

class GetSubSet
{
    /**
     * @var ITranslationGateway
     */
    protected $gateway;

    /**
     * @var ISubSetResponseTransformer
     */
    private $transformer;

    /**
     * GetSubSet constructor.
     *
     * @param ITranslationGateway             $gateway
     * @param ISubSetResponseTransformer|null $transformer
     */
    public function __construct(ITranslationGateway $gateway, ISubSetResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }

    public function execute(IGetSubSetRequest $request)
    {

        $boundary = $request->boundary();
        $items    = $this->gateway->getSubSet($request->catalogueId(), $boundary, $request->criteria());
        $total    = $this->gateway->subSetTotal($request->catalogueId(), $request->criteria());

        $collection = new PagedCollection($items, $total, $boundary->page, $boundary->pageSize);

        return $this->transformer()->transform($collection);

    }

    private function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new SubSetResponseTransformer();
        }

        return $this->transformer;
    }


}