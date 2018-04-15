<?php
/**
 * RunnerTest.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Tests\Unit\Components\Middleware;


use Tidy\Components\Exceptions\InvalidArgument;
use Tidy\Components\Middleware\IProcessor;
use Tidy\Components\Middleware\Runner;
use Tidy\Tests\MockeryTestCase;

class RunnerTest extends MockeryTestCase
{

    /**
     * @var runner
     */
    protected $runner;

    public function test_instantiation()
    {
        $runner = new Runner();
        $this->assertInstanceOf(Runner::class, $runner);
        $this->assertInstanceOf(IProcessor::class, $runner);
    }

    public function test_enqueue_throws_InvalidArgument()
    {
        $this->expectException(InvalidArgument::class);
        $this->runner->enqueue('blah');

    }

    public function test_process_is_executed_in_order()
    {
        $preprocessor = new Preprocessor();
        $this->assertInstanceOf(IProcessor::class, $preprocessor);
        $postprocessor = new Postprocessor();
        $this->assertInstanceOf(IProcessor::class, $postprocessor);

        $result = $this
            ->runner
            ->enqueue($preprocessor, $postprocessor, $preprocessor, $postprocessor)
            ->process(
                (object)['stack' => []],
                function ($object) {
                    $object->stack[] = 'core';

                    return $object;
                }
            )
        ;

        $this->assertCount(5, $result->stack);
        $this->assertEquals(['before', 'before', 'core', 'after', 'after'], $result->stack);


        $result = $this->runner->process((object)['stack' => ['core']]);

        $this->assertCount(5, $result->stack);
        $this->assertEquals('core', reset($result->stack));
    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->runner = new Runner();
    }


}