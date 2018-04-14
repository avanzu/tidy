<?php
/**
 * IProcessor.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Components\Middleware;


interface IProcessor
{
    public function process($input, callable $next);
}