<?php
/**
 * Runner.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Components\Middleware;


use Tidy\Exceptions\InvalidArgument;

/**
 * Class Runner
 */
class Runner implements IProcessor
{
    /**
     * @var array
     */
    protected $queue = [];

    /**
     * @param mixed ...$queue
     *
     * @return $this
     */
    public function enqueue(...$queue)
    {

        $this->clear();

        foreach ($queue as $item) {
            $this->addToQueue($item);
        }

        return $this;
    }


    /**
     * @param               $input
     * @param callable|null $next
     *
     * @return mixed
     */
    public function process($input, callable $next = null)
    {

        $middleware = array_reduce(
            array_reverse($this->queue),
            function ($next, $current) { return $this->make($next, $current); },
            $this->makeResolver($next)
        );

        return $middleware($input);
    }

    /**
     * @param callable|null $next
     *
     * @return \Closure
     */
    private function makeResolver(callable $next = null)
    {
        if (!is_callable($next)) {
            $next = function ($input) { return $input; };
        }

        return function ($input) use ($next) { return $next($input); };
    }

    /**
     * @param IProcessor $carry
     * @param            $next
     *
     * @return \Closure
     */
    private function make(callable $next, IProcessor $carry)
    {
        return function ($object) use ($carry, $next) {
            return $carry->process($object, $next);
        };

    }

    /**
     * @param $item
     */
    private function addToQueue($item)
    {
        if (!$item instanceof IProcessor) {
            throw new InvalidArgument(sprintf('Middleware processors must implement [%s].', IProcessor::class));
        }
        $this->queue[] = $item;
    }

    /**
     *
     */
    private function clear()
    {
        $this->queue = [];
    }

}