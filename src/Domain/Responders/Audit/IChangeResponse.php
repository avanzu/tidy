<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */
namespace Tidy\Domain\Responders\Audit;

interface IChangeResponse extends \Countable
{
    public function changes();
}