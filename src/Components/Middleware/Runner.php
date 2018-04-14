<?php
/**
 * Runner.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Components\Middleware;


use Tidy\Exceptions\InvalidArgument;

class Runner implements IProcessor
{
    protected $queue = [];

    public function enqueue(...$queue) {

        $this->clear();

        foreach ($queue as $item) {
            $this->addToQueue($item);
        }

        return $this;
    }



    public function process($input, callable $next = null) {

        $queue      = array_reverse($this->queue);
        $middleware = array_reduce($queue, function($next, $current){ return $this->make($current, $next); }, $this->makeResolver( $next ));

        return $middleware($input);
    }

    private function makeResolver(callable $next = null)
    {
        if( ! is_callable($next)) $next = function($input){ return $input; };
        return function($input) use ($next) { return $next($input); };
    }

    private function make(IProcessor $carry, $next)
    {
        return function($object) use ($carry, $next) {
            return $carry->process($object, $next);
        };

    }

    /**
     * @param $item
     */
    private function addToQueue($item)
    {
        if( ! $item instanceof IProcessor)
            throw new InvalidArgument(sprintf('Middleware processors must implement [%s].', IProcessor::class));
        $this->queue[] = $item;
    }

    private function clear()
    {
        $this->queue = [];
    }

}