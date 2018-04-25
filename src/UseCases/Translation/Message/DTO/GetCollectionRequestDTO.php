<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\Message\DTO;

use Tidy\Domain\Requestors\CollectionRequest;
use Tidy\Domain\Requestors\Translation\Message\IGetSubSetRequest;

class GetCollectionRequestDTO extends CollectionRequest implements IGetSubSetRequest
{
    protected $catalogueId;

    public function __construct(int $page, int $pageSize, array $criteria, $catalogueId)
    {
        $this->catalogueId = $catalogueId;
        parent::__construct($page, $pageSize, $criteria);
    }


    public function catalogueId()
    {
        return $this->catalogueId;
    }


}