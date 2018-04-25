<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Requestors\Translation\Message;

use Tidy\Domain\Requestors\ICollectionRequest;

interface IGetSubSetRequest extends ICollectionRequest
{
    public function catalogueId();

}