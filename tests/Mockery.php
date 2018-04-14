<?php
/**
 * Mockery.php
 * Tidy
 * Date: 14.04.18
 */

Mockery::globalHelpers();


if( ! function_exists('tear_down')) {
    function tear_down() {
        Mockery::close();
    }
}

if( ! function_exists('argumentThat')) {
    function argumentThat($callback) {
        return Mockery::on($callback);
    }
}

if( ! function_exists('identify')) {
    function identify($object, $identifier) {
        $reflection = new ReflectionObject($object);
        if( ! $reflection->hasProperty('id')) {
            throw new InvalidArgumentException(
                sprintf(
                    'The given object %s has no "id" attribute.', get_class($object)
                )
            );
        }

        $prop = $reflection->getProperty('id');
        $prop->setAccessible(true);
        $prop->setValue($object, $identifier);

        return $object;
    }
}
