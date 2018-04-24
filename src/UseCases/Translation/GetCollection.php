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
use Tidy\Domain\Requestors\Translation\IGetCollectionRequest;
use Tidy\Domain\Responders\Translation\ICollectionResponseTransformer;
use Tidy\UseCases\Translation\DTO\CollectionResponseTransformer;

class GetCollection
{
    /**
     * @var ITranslationGateway
     */
    protected $gateway;

    /**
     * @var ICollectionResponseTransformer
     */
    private $transformer;

    /**
     * GetCollection constructor.
     *
     * @param ITranslationGateway            $gateway
     * @param ICollectionResponseTransformer $transformer
     */
    public function __construct(ITranslationGateway $gateway, ICollectionResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }

    public function execute(IGetCollectionRequest $request)
    {

        $boundary = $request->boundary();
        $items    = $this->gateway->getCollection($boundary, $request->criteria());
        $total    = $this->gateway->total($request->criteria());

        $collection = new PagedCollection($items, $total, $boundary->page, $boundary->pageSize);

        return $this->transformer()->transform($collection);
    }

    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new CollectionResponseTransformer();
        }

        return $this->transformer;
    }


}