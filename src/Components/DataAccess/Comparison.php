<?php
/**
 * Comparison.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Components\DataAccess;


/**
 * Class Comparison
 */
class Comparison
{
    /**
     *
     */
    const EQ          = '=';
    /**
     *
     */
    const NEQ         = '<>';
    /**
     *
     */
    const LT          = '<';
    /**
     *
     */
    const LTE         = '<=';
    /**
     *
     */
    const GT          = '>';
    /**
     *
     */
    const GTE         = '>=';
    /**
     *
     */
    const IS          = '='; // no difference with EQ
    /**
     *
     */
    const IN          = 'IN';
    /**
     *
     */
    const NIN         = 'NIN';
    /**
     *
     */
    const CONTAINS    = 'CONTAINS';
    /**
     *
     */
    const MEMBER_OF   = 'MEMBER_OF';
    /**
     *
     */
    const STARTS_WITH = 'STARTS_WITH';
    /**
     *
     */
    const ENDS_WITH = 'ENDS_WITH';


    /**
     * @var string
     */
    private $operator;
    /**
     * @var
     */
    private $value;


    /**
     * ComparisonTest constructor.
     *
     * @param $operator
     * @param $value
     */
    public function __construct($value, $operator = self::EQ)
    {
        $this->value    = $value;
        $this->operator = $operator;
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $string
     *
     * @return static
     */
    public static function equalTo($string)
    {
        return new static($string, static::EQ);
    }

    /**
     * @param $string
     *
     * @return static
     */
    public static function containing($string)
    {
        return new static($string, static::CONTAINS);
    }

    /**
     * @return static
     */
    public static function isTrue()
    {
        return new static(true, static::EQ);
    }

    /**
     * @return static
     */
    public static function isFalse()
    {
        return new static(false, static::EQ);
    }

    /**
     * @param $value
     *
     * @return static
     */
    public static function greaterThan($value)
    {
        return new static($value, static::GT);
    }

    /**
     * @param $value
     *
     * @return static
     */
    public static function greaterOrEqualTo($value)
    {
        return new static($value, static::GTE);
    }

    /**
     * @param $value
     *
     * @return static
     */
    public static function lessThan($value)
    {
        return new static($value, static::LT);
    }

    /**
     * @param $value
     *
     * @return static
     */
    public static function lessOrEqualTo($value)
    {
        return new static($value, static::LTE);
    }

    /**
     * @return static
     */
    public static function isEmpty()
    {
        return new static(null, static::EQ);
    }

    /**
     * @return static
     */
    public static function isNotEmpty()
    {
        return new static(null, static::NEQ);
    }

    /**
     * @param $string
     *
     * @return static
     */
    public static function startsWith($string)
    {
        return new static($string, static::STARTS_WITH);
    }

    /**
     * @param $string
     *
     * @return static
     */
    public static function endsWith($string)
    {
        return new static($string, static::ENDS_WITH);
    }

    /**
     * @param mixed ...$values
     *
     * @return static
     */
    public static function in(...$values) {
        return new static($values, static::IN);
    }


    /**
     * @param mixed ...$values
     *
     * @return static
     */
    public static  function notIn(...$values)
    {
        return new static($values, static::NIN);
    }
}