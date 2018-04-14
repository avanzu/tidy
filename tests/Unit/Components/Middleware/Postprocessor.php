<?php
/**
 * Postprocessor.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Tests\Unit\Components\Middleware;


use Tidy\Components\Middleware\IProcessor;

class Postprocessor implements IProcessor
{
    public function process($input, callable $next)
    {
        $response = $next($input);
        $response->stack[] = 'after';
        return $response;
    }
}