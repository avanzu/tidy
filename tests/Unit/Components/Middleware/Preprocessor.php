<?php
/**
 * Preprocessor.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Tests\Unit\Components\Middleware;


use Tidy\Components\Middleware\IProcessor;

class Preprocessor implements IProcessor
{
    public function process($input, callable $next)
    {
        $input->stack[] = 'before';

        return $next($input);
    }
}