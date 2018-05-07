<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\Message;

use Tidy\Components\Collection\PagedCollection;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\Message\IGetSubSetRequest;
use Tidy\Domain\Responders\Translation\Message\ICollectionResponse;
use Tidy\Domain\Responders\Translation\Message\ICollectionResponseTransformer;
use Tidy\UseCases\Translation\Message\DTO\CollectionResponseTransformer;

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
     * @param ITranslationGateway                 $gateway
     * @param ICollectionResponseTransformer|null $transformer
     */
    public function __construct(ITranslationGateway $gateway, ICollectionResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }

    /**
     * @param IGetSubSetRequest $request
     *
     * @return ICollectionResponse
     */
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
            $this->transformer = new CollectionResponseTransformer();
        }

        return $this->transformer;
    }


}