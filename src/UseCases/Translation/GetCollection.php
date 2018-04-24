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
use Tidy\UseCases\Translation\DTO\CollectionResponseTransformer;
use Tidy\UseCases\Translation\DTO\GetCollectionRequestDTO;

class GetCollection
{
    /**
     * @var ITranslationGateway
     */
    protected $gateway;

    /**
     * @var CollectionResponseTransformer
     */
    private $transformer;

    /**
     * GetCollection constructor.
     *
     * @param ITranslationGateway           $gateway
     * @param CollectionResponseTransformer $transformer
     */
    public function __construct(ITranslationGateway $gateway, CollectionResponseTransformer $transformer = null) {
        $this->gateway = $gateway;
        $this->transformer = $transformer;
    }

    public function execute(GetCollectionRequestDTO $request) {

        $boundary = $request->boundary();
        $items    = $this->gateway->getCollection($boundary, $request->criteria());
        $total    = $this->gateway->total($request->criteria());

        $collection = new PagedCollection($items, $total, $boundary->page, $boundary->pageSize);

        return $this->transformer()->transform($collection);
    }

    protected function transformer() {
        if ( !$this->transformer ) $this->transformer = new CollectionResponseTransformer();
        return $this->transformer;
    }


}