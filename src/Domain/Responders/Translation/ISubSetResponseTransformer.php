<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Responders\Translation;

use Tidy\Components\Collection\IPagedCollection;

interface ISubSetResponseTransformer
{
    public function transform(IPagedCollection $collection);
}