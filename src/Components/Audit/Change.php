<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Components\Audit;

/**
 * Class Change
 *
 * @see https://tools.ietf.org/html/rfc6902
 */
class Change
{

    /**
     *
     */
    const OP_TEST = 'test';
    /**
     *
     */
    const OP_ADD = 'add';
    /**
     *
     */
    const OP_REMOVE = 'remove';
    /**
     *
     */
    const OP_REPLACE = 'replace';
    /**
     *
     */
    const OP_MOVE = 'move';
    /**
     *
     */
    const OP_COPY = 'copy';


    /**
     * @var
     */
    public $op;

    /**
     * @var
     */
    public $value;

    /**
     * @var
     */
    public $path;

    /**
     * @var
     */
    public $from;

    /**
     * Change constructor.
     *
     * @param $op
     * @param $value
     * @param $path
     * @param $from
     */
    public function __construct($op, $value, $path, $from)
    {
        $this->op    = $op;
        $this->value = $value;
        $this->path  = $path;
        $this->from  = $from;
    }

    /**
     * @param $value
     * @param $path
     *
     * @return Change
     */
    public static function test($value, $path)
    {
        return new static(static::OP_TEST, $value, $path, null);
    }

    /**
     * @param $value
     * @param $path
     *
     * @return Change
     */
    public static function add($value, $path)
    {
        return new static(static::OP_ADD, $value, $path, null);
    }

    /**
     * @param $path
     *
     * @return Change
     */
    public static function remove($path)
    {
        return new static(static::OP_REMOVE, null, $path, null);
    }

    /**
     * @param $value
     * @param $path
     *
     * @return Change
     */
    public static function replace($value, $path)
    {
        return new static(static::OP_REPLACE, $value, $path, null);
    }

    /**
     * @param $from
     * @param $path
     *
     * @return Change
     */
    public static function move($from, $path)
    {
        return new static(static::OP_MOVE, null, $path, $from);
    }

    /**
     * @param $from
     * @param $path
     *
     * @return Change
     */
    public static function copy($from, $path)
    {
        return new static(static::OP_COPY, null, $path, $from);
    }

}