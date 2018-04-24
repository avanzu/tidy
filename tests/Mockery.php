<?php
/**
 * Mockery.php
 * Tidy
 * Date: 14.04.18
 */

use Mockery\Matcher\AnyArgs;

if (!function_exists("mock")) {
    /**
     * @param mixed ...$args
     *
     * @return \Mockery\MockInterface
     * @see Mockery::mock()
     */
    function mock(...$args)
    {
        return call_user_func_array([Mockery::class, "mock"], $args);
    }
}

if (!function_exists("spy")) {

    /**
     * @param mixed ...$args
     *
     * @return \Mockery\MockInterface
     * @see Mockery::spy()
     */
    function spy(...$args)
    {
        return call_user_func_array([Mockery::class, "spy"], $args);
    }
}

if (!function_exists("namedMock")) {
    /**
     * @param mixed ...$args
     *
     * @return \Mockery\MockInterface
     * @see Mockery::namedMock()
     */
    function namedMock(...$args)
    {
        return call_user_func_array([Mockery::class, "namedMock"], $args);
    }
}

if (!function_exists("anyArgs")) {
    /**
     * @return AnyArgs
     */
    function anyArgs()
    {
        return new AnyArgs();
    }
}

if (!function_exists('tear_down')) {
    function tear_down()
    {
        Mockery::close();
    }
}

if (!function_exists('argumentThat')) {
    function argumentThat($callback)
    {
        return Mockery::on($callback);
    }
}

if (!function_exists('identify')) {
    function identify($object, $identifier)
    {
        $reflection = new ReflectionObject($object);
        if (!$reflection->hasProperty('id')) {
            throw new InvalidArgumentException(
                sprintf(
                    'The given object %s has no "id" attribute.',
                    get_class($object)
                )
            );
        }

        $prop = $reflection->getProperty('id');
        $prop->setAccessible(true);
        $prop->setValue($object, $identifier);

        return $object;
    }
}
